<?php

namespace CyberPanel\Collector\Collectors;

use CyberPanel\Collector\CollectorInterface;
use CyberPanel\System\Ups;
use CyberPanel\Utils\DateTime;

class UpsCollector implements CollectorInterface {

	public static function getStorageVariableName() : string {
		return 'upsstatus';
	}

	public function getTicks() : int {
		return 1;
	}

	public function collect() : array {
		$status = Ups::getInstance()->getUpsStatus();
		if (empty($status)) {
			return [];
		}
		return [
			'charge' => $status->getCharge(),
			'runtime' => [
				'human' =>	DateTime::secondsToHuman($status->getRuntime()),
				'seconds' => $status->getRuntime()
			],
			'power' => $status->getRealpower(),
			'load' => [
				'watts' => $status->getLoadInWatts(),
				'util' => $status->getLoad(),
			],
		];
	}
}
