<?php

namespace CyberPanel\Covid\NewsParsers;

use \DOMDocument;
use CyberPanel\Exceptions\RemoteContentNotDownloadedException;
use CyberPanel\Logging\Log;
use CyberPanel\Utils\WebDownloader;

class IdnesOnlineNews implements Parser {

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
			if (!empty($rslt) && $rslt[count($rslt) - 1]['microtime'] < $item['microtime']) {
				$item['microtime'] = $this->humanToMicrotime(
					trim($new->parentNode->childNodes[3]->textContent), TRUE
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
		return [
			'time' => trim($new->parentNode->childNodes[3]->textContent),
			'content' => trim($new->textContent),
			'html' => $html,
			'flag' => $flag,
			'microtime' => $this->humanToMicrotime(
				trim((string)$new->parentNode->childNodes[3]->textContent)
			),
			'important' => (bool)strpos(
				$new->ownerDocument->saveHTML($new->parentNode),
				'o-c3'
			),
		];
	}

	protected function humanToMicrotime(string $human, bool $dayBefore = FALSE) : int {
		$date = new \DateTime($human);
		if ($dayBefore) {
			$date->modify('-1 day');
		}
		return $date->getTimestamp();
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
