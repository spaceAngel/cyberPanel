<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\SystemInfo;
use CyberPanel\Configuration\Configuration;

class SystemInfoCommand extends BaseCommand {
	public function run() : array {
		$gpu = SystemInfo::getInstance()->getGpuInfo();
		$memory = SystemInfo::getInstance()->getMemory();
		return [
			'temperatures' => [
				'gpu' => $gpu->getTemperature(),
				'cpu' => SystemInfo::getInstance()->getTempCpu(),
			],
			'cpuload' => SystemInfo::getInstance()->getCpuLoad(),
			'memory' => [
				'used' => $memory->getUsed(),
				'total' => $memory->getTotal()
			],
			'processes' => SystemInfo::getInstance()->getProcessList(),
			'locked' => Systeminfo::getInstance()->isLockedScreen(),
			'gpu' => [
				'load' => $gpu->getLoad(),
				'memory' => [
					'free' => $gpu->getMemoryFree(),
					'total' => $gpu->getMemoryTotal(),
				]
			]
		];
	}
}
