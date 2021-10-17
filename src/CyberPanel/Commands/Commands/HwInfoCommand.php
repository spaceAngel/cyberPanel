<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\SystemInfo;

class HwInfoCommand extends BaseCommand {
	public function run() : array {
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
