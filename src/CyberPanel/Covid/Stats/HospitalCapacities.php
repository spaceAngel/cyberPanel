<?php

namespace CyberPanel\Covid\Stats;

use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Applications;

class HospitalCapacities {

	const URL = 'https://www.hlidacstatu.cz/KapacitaNemocnicData/last';

	protected static $lastFile;

	protected $regions = [
		'HKK' => 'Královohradecký',
		'JHC' => 'Jihočeský',
		'JHM' => 'Jihomoravský',
		'KVK' => 'Karlovarský',
		'LBK' => 'Liberecký',
		'MSK' => 'Moravskoslezký',
		'OLK' => 'Olomoucký',
		'PAK' => 'Pardubický',
		'PHA' => 'Praha',
		'PLK' => 'Plzeňský',
		'STC' => 'Středočeský',
		'ULK' => 'Ústecký',
		'VYS' => 'Vysočina',
		'ZLK' => 'Zlínský',
	];

	public function getCapacities() : array {

		$rslt = [];
		if (file_exists(self::$lastFile )) {
			$raw = file_get_contents(self::$lastFile);
			$json = json_decode($raw);
			if (!empty($json[0]->hospitals)) {
				$this->parseIntoHospitals($json, 0, $rslt);
			}
		}

		self::$lastFile = tempnam(sys_get_temp_dir(), '');
		Executer::execAndGetResponse(
			sprintf(Applications::CMD_DOWNLOAD_FILE, self::$lastFile, self::URL)
		);

		ksort($rslt);
		return $rslt;
	}

	protected function parseIntoHospitals(array $data, int $row, array &$rslt) : void {
		foreach ($data[$row]->hospitals as $item) {
			$region = $this->getRegionName($item->region);
			if (!array_key_exists($region, $rslt)) {
				$rslt[$region] = [];
			}
			if (!array_key_exists($row, $rslt[$region])) {
				$rslt[$region][$row] = $this->getEmptyStruct();
			}
			$rslt[$region][$row]['upv']['total'] += $item->UPV_celkem;
			$rslt[$region][$row]['upv']['free'] += $item->UPV_volna;
			$rslt[$region][$row]['icu']['total'] += $item->AROJIP_luzka_celkem;
			$rslt[$region][$row]['icu']['free']['covid'] += $item->AROJIP_luzka_covid;
			$rslt[$region][$row]['icu']['free']['noncovid'] += $item->AROJIP_luzka_necovid;
			$rslt[$region][$row]['standard']['total'] += $item->Standard_luzka_s_kyslikem_celkem;
			// phpcs:disable Generic.Files.LineLength
			$rslt[$region][$row]['standard']['free']['covid'] += $item->Standard_luzka_s_kyslikem_covid;
			$rslt[$region][$row]['standard']['free']['noncovid'] += $item->Standard_luzka_s_kyslikem_necovid;
			// phpcs:enable
			$rslt[$region][$row]['nurses'] += $item->Sestry_AROJIP_celkem;
			$rslt[$region][$row]['doctors'] += $item->Lekari_AROJIP_celkem;
		}
	}

	protected function getRegionName(string $code) : string {
		if (array_key_exists($code, $this->regions)) {
			return $this->regions[$code];
		}
		return $code;
	}

	protected function getEmptyStruct() : array {
		return [
			'upv' => [
				'total' => 0,
				'free' => 0,
			],
			'icu' => [
				'total' => 0,
				'free' => [
					'covid' => 0,
					'noncovid' => 0,
				]
			],
			'standard' => [
				'total' => 0,
				'free' => [
					'covid' => 0,
					'noncovid' => 0,
				]
			],
			'nurses' => 0,
			'doctors' => 0,
		];
	}
}
