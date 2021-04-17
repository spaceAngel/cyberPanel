<?php

namespace CyberPanel\Covid\NewsParsers;

use \DOMDocument;
use CyberPanel\Exceptions\RemoteContentNotDownloadedException;
use CyberPanel\Logging\Log;
use CyberPanel\Utils\WebDownloader;
use CyberPanel\Utils\DateTime;

class Ct24News implements Parser {

	// phpcs:disable Generic.Files.LineLength
	const LOGO_URL = 'https://ct24.ceskatelevize.cz/sites/all/themes/custom/ct24/css/compiled/assets/images/logo-ct24-colored.png';
	const URL = 'https://www.ceskatelevize.cz/sport/ajax/onlineReport/';
	const POST_PARAMS = 'onlineReportId=1129&page=1';
	const XPATH = '//dl[contains(@class, "onlineReportContent")]/*[self::dt or self::dd]';
	// phpcs:enable

	public function getNews() : array {
		try {
			$html = WebDownloader::download(self::URL, self::POST_PARAMS);
		} catch (RemoteContentNotDownloadedException $e) {
			Log::error('Error during contacting CT24 News on URL: %s', [self::URL]);
			return [];
		}

		return $this->parseNews($html);
	}

	protected function parseNews(string $html) : array {
		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR);
		$parser = new \DOMXPath($dom);
		$news = $parser->query(self::XPATH);
		$rslt = [];
		foreach ($news as $key => $new) {
			switch ($key % 2) {
				case 0:
					$article = [
					'time' => $new->textContent,
					'microtime' => DateTime::humanToMicrotime($new->textContent),
					'logo' => self::LOGO_URL,
					];
					if ($article['microtime'] > time()) {
						$article['microtime']  = DateTime::humanToMicrotime($new->textContent, TRUE);
					}
					break;
				case 1:
					$article['html'] = $new->textContent;
					$rslt[] = $article;
					break;
			}
		}
		return $rslt;
	}
}
