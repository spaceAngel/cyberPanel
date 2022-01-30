<?php

namespace CyberPanel\Collector\Collectors;

use CyberPanel\Collector\CollectorInterface;
use CyberPanel\System\SystemInfo;

class HwCollector implements CollectorInterface {

	public static function getStorageVariableName() : string {
		return 'hwinfo';
	}

	public function getTicks() : int {
		return 20;
	}

	public function collect() : array {
		return [
			'storages' => $this->buildStorageStruct(),
			'gpu' => SystemInfo::getInstance()->getGpuName(),
			'cpu' => SystemInfo::getInstance()->getCpuName(),
			'kernel' => SystemInfo::getInstance()->getKernelVersion(),
			'distro' => SystemInfo::getInstance()->getDistro(),
			'uptime' => SystemInfo::getInstance()->getUptime(),
		];
	}

	protected function buildStorageStruct() : array {
		$rslt = [];
		foreach (SystemInfo::getInstance()->getStorages() as $storage) {
			$rslt[] = [
					'caption' => $storage->getName(),
					'size' => $storage->getSize(),
					'used' => $storage->getUsed(),
					'available' => $storage->getAvailable(),
			];
		}
		return $rslt;
	}
}
