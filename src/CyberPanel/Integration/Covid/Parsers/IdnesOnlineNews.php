<?php

namespace CyberPanel\Integration\Covid\Parsers;

use \DOMDocument;
use CyberPanel\Exceptions\RemoteContentNotDownloadedException;
use CyberPanel\Logging\Log;
use CyberPanel\Utils\WebDownloader;
use CyberPanel\Utils\DateTime;

class IdnesOnlineNews {

	const URL_IDNES = 'https://www.idnes.cz/koronavirus/online';

	public function getNews() : array {
		$dom = new DOMDocument('1.0', 'UTF-8');
		try {
			$html = WebDownloader::download(self::URL_IDNES);
		} catch (RemoteContentNotDownloadedException $e) {
			Log::error('Error during contacting IdnesNews on URL: %s', [self::URL_IDNES]);
			return [];
		}
		$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR);
		$parser = new \DOMXPath($dom);
		$news = $parser->query('//div[contains(@class, "event")]');
		$rslt = [];
		foreach ($news as $new) {
			$item = $this->parseItem($new);
			if (time() < $item['microtime']) {
				$time = $this->fixTimeString(
					trim($new->parentNode->childNodes[3]->textContent)
				);
				$item['microtime'] = DateTime::humanToMicrotime(
					$time, TRUE
				);
			}
			$rslt[] = $item;
		}
		return $rslt;
	}

	protected function parseItem($new) {
		$html = trim($new->ownerDocument->saveHTML($new));
		$html = $this->cleanTwitter($html);
		$html = $this->makeLinksClickable($html);
		$flag = $new->ownerDocument->saveHTML($new->parentNode->childNodes[5]->childNodes[0]);
		$flag = substr($flag, 0, 4) == '<img' ? $flag : '';
		$time = $this->fixTimeString(
			trim($new->parentNode->childNodes[3]->textContent)
		);
		return [
			'time' => $time,
			'content' => trim($new->textContent),
			'md5' => md5($html),
			'html' => $html,
			'flag' => $flag,
			'microtime' => DateTime::humanToMicrotime($time),
			'important' => (bool)strpos(
				$new->ownerDocument->saveHTML($new->parentNode),
				'o-c3'
			),
		];
	}

	protected function fixTimeString(string $time) : string {
		return str_replace('%', '0', $time);
	}

	protected function cleanTwitter(string $html) : string {
		$html = preg_replace('/<div class="es-bot">(.+)<\/div>/', "", $html);
		$html = preg_replace('/<div class="es-date">(.+)<\/div>/', "", $html);
		return $html;
	}

	protected function makeLinksClickable(string $html) : string {
		$html = str_replace('<a', '<a onclick="return openBrowser(this);" ', $html);
		return $html;
	}


}
