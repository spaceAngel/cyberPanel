<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\SystemInfo;
use CyberPanel\Configuration\Configuration;

class SystemInfoCommand extends BaseCommand {
	public function run() : array {
		$gpu = SystemInfo::getInstance()->getGpuInfo();
		return [
			'temperatures' => [
				'gpu' => $gpu->getTemperature(),
				'cpu' => SystemInfo::getInstance()->getTempCpu(),
				'limits' => [
					'cpu' => Configuration::getInstance()->getSystemLimits()->getTempCpu(),
					'gpu' => Configuration::getInstance()->getSystemLimits()->getTempGpu(),
				] ,
			],
			'cpuload' => SystemInfo::getInstance()->getCpuLoad(),
			'memory' => SystemInfo::getInstance()->getMemory(),
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
