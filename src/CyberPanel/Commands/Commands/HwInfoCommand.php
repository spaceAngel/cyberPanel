<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\SystemInfo;
use CyberPanel\Configuration\Configuration;

class HwInfoCommand extends BaseCommand {
	public function run() : array {
		return [
			'storages' => SystemInfo::getInstance()->getStorages(),
			'gpu' => SystemInfo::getInstance()->getGpuName(),
			'cpu' => SystemInfo::getInstance()->getCpuName(),
			'kernel' => SystemInfo::getInstance()->getKernelVersion(),
			'distro' => SystemInfo::getInstance()->getDistro(),
			'uptime' => SystemInfo::getInstance()->getUptime(),
		];
	}
}
