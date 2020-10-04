<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use \DOMDocument;

class CovidCommand extends BaseCommand{

	const URL_IDNES = 'https://www.idnes.cz/koronavirus/online';

	public function run() : array {
		return [
			'news' => $this->parseIdnesOnline()
		];
	}

	protected function parseIdnesOnline() : array {
		$dom = new DOMDocument();
		$dom->loadHTMLFile(self::URL_IDNES, LIBXML_NOERROR);
		$parser = new \DOMXPath($dom);
		$news = $parser->query('//div[contains(@class, "event")]');
		$rslt = [];
		foreach ($news as $new) {
			$rslt[] = [
				'time' => trim($new->parentNode->childNodes[3]->textContent),
				'content' => trim($new->textContent),
				'html' => $this->cleanTwitter(trim($new->ownerDocument->saveHTML($new))),
				'flag' => trim(
					$new->ownerDocument->saveHTML($new->parentNode->childNodes[5]->childNodes[0])
				)
			];
		}
		return $rslt;
	}

	protected function cleanTwitter(string $html) : string {
		$html = preg_replace('/<div class="es-bot">(.+)<\/div>/', "", $html);
		$html = preg_replace('/<div class="es-date">(.+)<\/div>/', "", $html);
		return $html;
	}
}
