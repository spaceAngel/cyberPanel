<?php

namespace CyberPanel\Covid\Stats;

class Summary {

	// phpcs:disable Generic.Files.LineLength

	const URL_MZCR_STATS = 'https://onemocneni-aktualne.mzcr.cz/api/v2/covid-19/zakladni-prehled.json';

	const URL_MZCR_PES = 'https://share.uzis.cz/s/BRfppYFpNTddAy4/download?path=%2F&files=pes_CR.csv';

	protected array $levels = [
		1 => 20,
		2 => 40,
		3 => 60,
		4 => 75,
		5 => 100,
	];
	// phpcs::enable

	public function getStats() : array {
		$raw = file_get_contents(self::URL_MZCR_STATS);
		$json = json_decode($raw);
		$data = $json->data[0];
		$pesScore = $this->getPes();
		return [
			'pes' => [
				'score' => $pesScore,
				'level' => $this->getPesLevel($pesScore),
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

}
