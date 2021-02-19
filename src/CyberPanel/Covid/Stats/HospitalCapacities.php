<?php

namespace CyberPanel\Covid\Stats;

use CyberPanel\Utils\WebDownloader;

class HospitalCapacities {

	const URL = 'https://dip.mzcr.cz/api/v1/kapacity-intenzivni-pece-vlna-2.csv';

	protected $regions = [
		'CZ052' => 'Královohradecký',
		'CZ031' => 'Jihočeský',
		'CZ064' => 'Jihomoravský',
		'CZ041' => 'Karlovarský',
		'CZ051' => 'Liberecký',
		'CZ080' => 'Moravskoslezký',
		'CZ071' => 'Olomoucký',
		'CZ053' => 'Pardubický',
		'CZ010' => 'Praha',
		'CZ032' => 'Plzeňský',
		'CZ020' => 'Středočeský',
		'CZ042' => 'Ústecký',
		'CZ063' => 'Vysočina',
		'CZ072' => 'Zlínský',
	];

	public function getCapacities() : array {
		$rslt = [];
		$file = explode("\n", WebDownloader::download(self::URL));
		$headers = array_flip(
			str_getcsv(array_shift($file), ',')
		);
		$file = array_reverse($file);

		foreach ($file as $row) {
			if (empty($row)) continue;
			$regionRow = str_getcsv($row, ',');
			if (!isset($date)) {
				$date = $regionRow[0];
			}

			if ($regionRow[0] != $date) {
				ksort($rslt);
				return $rslt;
			}
			$regionName = $this->getRegionName($regionRow[1]);
			$rslt[$regionName] = $this->parseRow($regionRow, $headers);
		}
		return [];
	}


	protected function parseRow(array $row, array $headers) : array {
		return [
			'upv' => [
				'total' => $row[$headers['upv_kapacita_celkem']],
				'free' => $row[$headers['upv_kapacita_volna']],
			],
			'icu' => [
				'total' => $row[$headers['luzka_aro_jip_kapacita_celkem']],
				'free' => [
					'covid' => $row[$headers['luzka_aro_jip_kapacita_volna_covid_pozitivni']],
					'noncovid' => $row[$headers['luzka_aro_jip_kapacita_volna_covid_negativni']],
				],
			],
			'standard' => [
				'total' => $row[$headers['luzka_standard_kyslik_kapacita_celkem']],
				'free' => [
					// phpcs:disable Generic.Files.LineLength
					'covid' => $row[$headers['luzka_standard_kyslik_kapacita_volna_covid_pozitivni']],
					'noncovid' => $row[$headers['luzka_standard_kyslik_kapacita_volna_covid_negativni']],
					// phpcs:enable
				],
			],
			'nurses' => 0,
			'doctors' => 0,
		];
	}

	protected function getRegionName(string $code) : string {
		if (array_key_exists($code, $this->regions)) {
			return $this->regions[$code];
		}
		return $code;
	}

}
