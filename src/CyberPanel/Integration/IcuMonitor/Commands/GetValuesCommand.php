<?php

namespace CyberPanel\Integration\IcuMonitor\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Utils\Miscellaneous;
use CyberPanel\Integration\DownloadManager\DownloadManager;
use CyberPanel\Integration\IcuMonitor\ValueStorage;
use Carbon\Carbon;

class GetValuesCommand extends BaseCommand {


	public function run() : array {
		return [
			'spo2' => [
				'pulse' => ValueStorage::getInstance()->getSpo2Pulse(),
				'saturation' => ValueStorage::getInstance()->getSpo2(),
			],
			'ecg' => [
				'pulse' => ValueStorage::getInstance()->getEcgPulse()
			],
			'respiratoryRate' => ValueStorage::getInstance()->getRespiratoryRate(),
			'nbp' => [
				'sys' => ValueStorage::getInstance()->getNbpSys(),
				'dias' => ValueStorage::getInstance()->getNbpDias(),
				'mean' => ValueStorage::getInstance()->getNbpMean(),
				'inflating' => ValueStorage::getInstance()->getNbpInflating(),
				'time' => [
					'timestamp' => ValueStorage::getInstance()->getNbpTimestamp(),
					'human' => Carbon::createFromTimestamp(
						ValueStorage::getInstance()->getNbpTimestamp()
					)->format('H:i')

				],

			],
			'refreshRate' => ValueStorage::getInstance()->getRefreshRate(),
		];
	}
}
