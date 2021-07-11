<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\SystemInfo;
use CyberPanel\Configuration\Configuration;
use CyberPanel\Utils\Miscellaneous;
use CyberPanel\System\Ups;
use CyberPanel\Utils\DateTime;

class UpsStateCommand extends BaseCommand {

	public function run() : array {
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
