<?php

namespace CyberPanel\Covid\Stats;

class Summary {

	// phpcs:disable Generic.Files.LineLength

	const URL_MZCR_STATS = 'https://onemocneni-aktualne.mzcr.cz/api/v2/covid-19/zakladni-prehled.json';

	const URL_MZCR_PES = 'https://share.uzis.cz/s/BRfppYFpNTddAy4/download?path=%2F&files=pes_CR.csv';

	const URL_MZCR_PES_OFFICIAL = 'https://onemocneni-aktualne.mzcr.cz/pes';

	CONST REGEXP_MZCR_PES_OFFICIAL = '/html/body/main/div[3]/div/div[1]/div[2]/div/div[2]/table/tbody/tr[2]/td/p/span';

	protected array $levels = [
		1 => 20,
		2 => 40,
		3 => 60,
		4 => 75,
		5 => 100,
	];
	// phpcs::enable

	public function getStats() : array {

		$officialPes = $this->getOfficialPesLevel();
		$raw = file_get_contents(self::URL_MZCR_STATS);
		$json = json_decode($raw);
		$data = $json->data[0];
		$pesScore = $this->getPes();
		return [
			'pes' => [
				'current' => [
					'score' => $pesScore,
					'level' => $this->getPesLevel($pesScore),
				],
				'official' => [
					'score' => $this->levels[$officialPes],
					'level' => $officialPes,
				]
			],
			'cases' => [
				'yesterday' => $data->potvrzene_pripady_vcerejsi_den,
				'total' => $data->aktivni_pripady
			],
			'tests' => $data->provedene_testy_vcerejsi_den,
			'hospitalised' => $data->aktualne_hospitalizovani,
			'deaths' => $data->umrti,
		];
	}

	protected function getPes() : int {
		$csv = file_get_contents(self::URL_MZCR_PES);
		$csv = explode("\n", $csv);
		$header = str_getcsv($csv[0], ';');
		$header = array_flip($header);
		array_pop($csv);
		$lastPes = str_getcsv(array_pop($csv), ';');
		return $lastPes[$header['body']];
	}

	protected function getPesLevel(int $actualScore) : int {
		foreach ($this->levels as $pes => $score) {
			if ($actualScore <= $score) {
				return $pes;
			}
		}
	}

	protected function getOfficialPesLevel() : int {
		$dom = new \DOMDocument();
		$dom->loadHTMLFile(self::URL_MZCR_PES_OFFICIAL, LIBXML_NOERROR);
		$parser = new \DOMXPath($dom);
		$actualLevel = $parser->query(self::REGEXP_MZCR_PES_OFFICIAL);
		$text = $actualLevel[0]->textContent;
		return (int)substr($text, 8, 1);
	}

}
