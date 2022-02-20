<?php

namespace CyberPanel\Integration\News\Parsers\Parsers;

use CyberPanel\Exceptions\RemoteContentNotDownloadedException;
use CyberPanel\Integration\News\Parsers\ParserInterface;
use CyberPanel\Logging\Log;
use CyberPanel\Utils\WebDownloader;
use CyberPanel\Utils\DateTime;

use \DOMDocument;
use \DOMElement;
use \DOMXPath;

use Carbon\Carbon;

class UaLiveMap implements ParserInterface {

	protected const MAX_INTEMS = 10;

	public function getNews(string $url) : array {
		$dom = new DOMDocument('1.0', 'UTF-8');
		try {
			$html = WebDownloader::download($url);
		} catch (RemoteContentNotDownloadedException $e) {
			Log::error('Error during contacting UaLiveMap on URL');
			return [];
		}
		$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR);
		$parser = new \DOMXPath($dom);
		$news = $parser->query('//div[starts-with(@id, "post-")]');
		$rslt = [];
		foreach ($news as $i => $new) {
			$item = $this->parseItem($new, $parser);
			if ($item) {
				$rslt[] = $item;
			}

			if ($i == self::MAX_INTEMS) {
				break;
			}

		}
		return $rslt;
	}

	protected function parseItem(
		DOMElement $new,
		DOMXPath $parser
	) : array {
		$timeModification = $parser->query(
			'.//span[starts-with(@class, "date_add")]',
			$new
		)[0]->textContent;
		$content = $this->getHtmlContent($new, $parser);

		$time = $this->parseTime($timeModification);
		return [
			'time' => $time->format('H:i'),
			'content' => $content,
			'md5' => md5($content),
			'html' => $content,
			'flag' => NULL,
			'microtime' => DateTime::humanToMicrotime($time),
			'important' => FALSE,
		];
	}

	protected function getHtmlContent(
		DomElement $item,
		DOMXPath $parser
	) : string {
		$content = $parser->query(
			'.//a[starts-with(@class, "comment-link")]',
			$item
		)[0]->getAttribute('title');

		$imgs = $parser->query('.//img', $item);

		if (count($imgs) > 1) {
			$binary = $this->getImage($imgs[1]->getAttribute('src'));
			if (!empty($binary)) {
				$img = sprintf(
					'<img src="%s" />',
					$this->getImage($imgs[1]->getAttribute('src'))
				);
			}
		}

		return sprintf(
			'<div class="onlyText">%s%s</div>',
			$content,
			isset($img) ? $img : ''
		);
	}

	protected function getImage(string $url) : ?string {
		try {
			$binary = WebDownloader::download($url);
			return sprintf(
				'data:image/%s;base64,%s',
				pathinfo(parse_url($url)['path'])['extension'],
				base64_encode($binary)
			);
		} catch (RemoteContentNotDownloadedException $e) {
			return NULL;
		}
	}

	protected function parseTime(string $modificationString) : ?Carbon {
		$modificationString = str_replace(
			['an', 'ago', 'minute ', 'hour '],
			['', '', 'minutes ', 'hours '],
			$modificationString
		);
		return Carbon::now()->modify(' -' . $modificationString);
	}

}
