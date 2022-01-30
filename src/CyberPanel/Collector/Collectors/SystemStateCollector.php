<?php

namespace CyberPanel\Collector\Collectors;

use CyberPanel\Collector\CollectorInterface;
use CyberPanel\System\SystemInfo;
use CyberPanel\DataStructs\System\GpuSystemInfo;
use CyberPanel\Utils\Miscellaneous;
use CyberPanel\Events\EventManager;
use CyberPanel\Events\Events\Hardware\GpuTemperatureEvent;
use CyberPanel\Events\Events\Hardware\CpuTemperatureEvent;

class SystemStateCollector implements CollectorInterface {

	public static function getStorageVariableName() : string {
		return 'systen';
	}

	public function getTicks() : int {
		return 1;
	}

	public function collect() : array {
		$gpu = SystemInfo::getInstance()->getGpuInfo();
		$memory = SystemInfo::getInstance()->getMemory();
		$rslt = [
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
			'locked' => SystemInfo::getInstance()->isLockedScreen(),
			'gpu' => $this->getGpuInfo($gpu),
		];
		$this->fireEvents($rslt);
		return $rslt;
	}

	protected function getGpuInfo(GpuSystemInfo $gpu) : array {
		return [
			'load' => $gpu->getLoad(),
			'memory' => [
				'free' => $gpu->getMemoryFree(),
				'total' => $gpu->getMemoryTotal(),
			]
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

	protected function fireEvents(array $struct) : void {
		EventManager::getInstance()->event(
			new CpuTemperatureEvent($struct['temperatures']['cpu'])
		);
		EventManager::getInstance()->event(
			new GpuTemperatureEvent($struct['temperatures']['gpu'])
		);
	}

}
