<?php

namespace CyberPanel\System;

class SystemInfo {

	// phpcs:disable Generic.Files.LineLength
	const CMD_TEMP_CPU = "sensors|sed -E -n '/[0-9]:.*\+[0-9]+\.[0-9]°[CF]/!b;s:\.[0-9]*°[CF].*$::;s:^.*\+::;p'";

	const CMD_TEMP_GPU = 'nvidia-smi --query-gpu=temperature.gpu --format=csv,noheader';

	const CMD_STORAGES = 'df --output=source,target,size,avail,used';

	const CMD_CPU_LOAD = "awk -v a=\"$(awk '/cpu /{print $2+$4,$2+$4+$5}' /proc/stat; sleep 0.2)\" '/cpu /{split(a,b,\" \"); print 100*($2+$4-b[1])/($2+$4+$5-b[2])}'  /proc/stat";

	const CMD_MEMORY = "free | awk '/Mem:/ { print sprintf(\"%u %u\",$2, $3+$5) }' ";
	// phpcs:enable

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

	public function getCpuLoad() {
		return round(Executer::execAndGetResponse(self::CMD_CPU_LOAD), 2);

	}

	public function getMemory() {
		$memory = explode(' ', Executer::execAndGetResponse(self::CMD_MEMORY));
		return [
			'total' => $memory[0],
			'used' => $memory[1],
		];
	}


}
