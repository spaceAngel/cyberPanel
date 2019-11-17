<?php

namespace CyberPanel\System;

class SystemInfo {

	// phpcs:disable Generic.Files.LineLength
	const CMD_TEMP_CPU = "sensors|sed -E -n '/[0-9]:.*\+[0-9]+\.[0-9]°[CF]/!b;s:\.[0-9]*°[CF].*$::;s:^.*\+::;p'";
	// phpcs:enable
	const CMD_TEMP_GPU = 'nvidia-smi --query-gpu=temperature.gpu --format=csv,noheader';

	const CMD_STORAGES = 'df --output=source,target,size,avail,used';

	private $skipStorageFormats = ['tmpfs', 'udev'];

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new Self();
		}
		return self::$instance;
	}

	public function getTempGpu() {
		return Executer::execAndGetResponse(self::CMD_TEMP_GPU);
	}

	public function getTempCpu() {
		return Executer::execAndGetResponse(self::CMD_TEMP_CPU);
	}

	public function getStorages() : array {
		$disks = explode("\n", Executer::execAndGetResponse(self::CMD_STORAGES));
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
}
