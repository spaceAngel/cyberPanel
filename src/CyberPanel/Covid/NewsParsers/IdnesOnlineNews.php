<?php

namespace CyberPanel\Covid\NewsParsers;

use \DOMDocument;

class IdnesOnlineNews implements Parser {

	const URL_IDNES = 'https://www.idnes.cz/koronavirus/online';

	public function getNews() : array {
		$dom = new DOMDocument();
		$dom->loadHTMLFile(self::URL_IDNES, LIBXML_NOERROR);
		$parser = new \DOMXPath($dom);
		$news = $parser->query('//div[contains(@class, "event")]');
		$rslt = [];
		foreach ($news as $new) {
			$html = trim($new->ownerDocument->saveHTML($new));
			$html = $this->cleanTwitter($html);
			$html = $this->makeLinksClickable($html);
			$flag = $new->ownerDocument->saveHTML($new->parentNode->childNodes[5]->childNodes[0]);
			$flag = substr($flag, 0, 4) == '<img' ? $flag : '';
			$rslt[] = [
				'time' => trim($new->parentNode->childNodes[3]->textContent),
				'content' => trim($new->textContent),
				'html' => $html,
				'flag' => $flag,
				'microtime' => $this->humanToMicrotime(
					trim($new->parentNode->childNodes[3]->textContent)
				),
				'important' => (bool)strpos(
					$new->ownerDocument->saveHTML($new->parentNode),
					'o-c3'
				),
			];
		}
		return $rslt;
	}

	protected function humanToMicrotime(string $human) : int {
		$date = new \DateTime($human);
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
