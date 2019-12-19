<?php

namespace CyberPanel\System;

use CyberPanel\System\ShellCommands\SystemInfo as SystemInfoCommands;

class SystemInfo {

	private $skipStorageFormats = ['tmpfs', 'udev', 'devtmpfs', 'squashfs', 'iso9660'];

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new Self();
		}
		return self::$instance;
	}

	public function getTempGpu() : int {
		$temp = Executer::execAndGetResponse(SystemInfoCommands::CMD_TEMP_GPU);
		return (int)$temp == $temp ? (int)$temp : 0;
	}

	public function getTempCpu() {
		$temps = explode("\n", Executer::execAndGetResponse(SystemInfoCommands::CMD_TEMP_CPU));
		return $temps[count($temps) - 2];
	}

	public function getStorages() : array {
		$disks = explode("\n", Executer::execAndGetResponse(SystemInfoCommands::CMD_STORAGES));
		$rslt = [];
		array_shift($disks);
		foreach ($disks as $diskRaw) {
			$disk = preg_split("/[\s,]+/", $diskRaw);
			if (empty($disk[0]) || in_array($disk[0], $this->skipStorageFormats)) continue;
			$rslt[] = [
				'caption' => $disk[1],
				'size' => $disk[2],
				'available' => $disk[3],
				'used' => $disk[4],
			];
		}
		return $rslt;
	}

	public function getCpuLoad() {
		return round(Executer::execAndGetResponse(SystemInfoCommands::CMD_CPU_LOAD), 2);

	}

	public function getMemory() {
		$memory = explode(' ', Executer::execAndGetResponse(SystemInfoCommands::CMD_MEMORY));
		return [
			'total' => $memory[0],
			'used' => $memory[1],
		];
	}


}
