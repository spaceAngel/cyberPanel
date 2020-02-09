<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\SystemInfo;
use CyberPanel\Configuration\Configuration;

class SystemInfoCommand extends BaseCommand {
	public function run() : array {
		return [
			'temperatures' => [
				'gpu' => SystemInfo::getInstance()->getTempGpu(),
				'cpu' => SystemInfo::getInstance()->getTempCpu(),
				'limits' => [
					'cpu' => Configuration::getInstance()->getSystemLimits()->getTempCpu(),
					'gpu' => Configuration::getInstance()->getSystemLimits()->getTempGpu(),
				] ,
			],
			'storages' => SystemInfo::getInstance()->getStorages(),
			'cpuload' => SystemInfo::getInstance()->getCpuLoad(),
			'memory' => SystemInfo::getInstance()->getMemory(),
			'processes' => SystemInfo::getInstance()->getProcessList(),
		];
	}
}
