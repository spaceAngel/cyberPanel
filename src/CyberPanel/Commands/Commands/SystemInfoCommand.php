<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\SystemInfo;

class SystemInfoCommand extends BaseCommand {
	public function run() : array {
		return [
			'temperatures' => [
				'gpu' => SystemInfo::getInstance()->getTempGpu(),
				'cpu' => SystemInfo::getInstance()->getTempCpu()
			],
			'storages' => SystemInfo::getInstance()->getStorages()
		];
	}
}
