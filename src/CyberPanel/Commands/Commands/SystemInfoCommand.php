<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\SystemInfo;
use CyberPanel\Configuration\Configuration;
use CyberPanel\Utils\Miscellaneous;

class SystemInfoCommand extends BaseCommand {
	public function run() : array {
		$gpu = SystemInfo::getInstance()->getGpuInfo();
		$memory = SystemInfo::getInstance()->getMemory();
		return [
			'temperatures' => [
				'gpu' => $gpu->getTemperature(),
				'cpu' => SystemInfo::getInstance()->getTempCpu(),
			],
			'cpu' => [
				'load' => SystemInfo::getInstance()->getCpuLoad(),
				'frequency' => SystemInfo::getInstance()->getCpuFrequency(),
			],
			'memory' => [
				'used' => $this->formatMemory($memory->getUsed()),
				'total' => $this->formatMemory($memory->getTotal()),
				'load' => $memory->getLoad()
			],
			'fans' => $this->getFans(),
			'processes' => SystemInfo::getInstance()->getProcessList(),
			'locked' => Systeminfo::getInstance()->isLockedScreen(),
			'gpu' => [
				'load' => $gpu->getLoad(),
				'memory' => [
					'free' => $gpu->getMemoryFree(),
					'total' => $gpu->getMemoryTotal(),
				]
			],
		];
	}

	protected function getFans() : array {
		$rslt = [];
		$fans = SystemInfo::getInstance()->getChaseFanSpeed();
		foreach ($fans as $name => $fan) {
			$rslt[$name] = [
				'speed' => $fan->getSpeed(),
				'min' => $fan->getMin(),
				'max' => $fan->getMax(),
				'utilisation' => $fan->getUtilisation()
			];
		}
		return $rslt;
	}

	protected function formatMemory(int $bytes) : array {
		return [
			'bytes' => $bytes,
			'human' => Miscellaneous::bytesToHuman($bytes)
		];

	}
}
