<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use \DOMDocument;

class CovidCommand extends BaseCommand{

	// phpcs:disable Generic.Files.LineLength
	const URL_IDNES = 'https://www.idnes.cz/koronavirus/online';
	const URL_MZCR_STATS = 'https://onemocneni-aktualne.mzcr.cz/api/v2/covid-19/zakladni-prehled.json';
	// phpcs::enable

	public function run() : array {
		return [
			'news' => $this->parseIdnesOnline(),
			'stats' => $this->parseMzcrStats(),
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

	protected function parseMzcrStats() : array {
		$raw = file_get_contents(self::URL_MZCR_STATS);
		$json = json_decode($raw);
		$data = $json->data[0];

		return [
			'cases' => [
				'today' => $data->potvrzene_pripady_dnesni_den,
				'yesterday' => $data->potvrzene_pripady_vcerejsi_den,
				'total' => $data->aktivni_pripady
			],
			'tests' => $data->provedene_testy_vcerejsi_den,
			'hospitalised' => $data->aktualne_hospitalizovani,
			'deaths' => $data->umrti,
		];
	}
}
