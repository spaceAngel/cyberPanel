<?php

namespace CyberPanel\System;

use CyberPanel\System\ShellCommands\SystemInfo as SystemInfoCommands;
use CyberPanel\System\ShellCommands\GraphicNvidia;
use CyberPanel\DataStructs\System\GpuSystemInfo;
use CyberPanel\DataStructs\System\MemoryInfo;
use CyberPanel\Utils\Miscellaneous;

class SystemInfo {

	private $skipStorageFormats = ['tmpfs', 'udev', 'devtmpfs', 'squashfs', 'iso9660'];

	private $skipMountPoints = ['/boot/efi'];

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new Self();
		}
		return self::$instance;
	}

	public function getTempCpu() {
		$temps = explode("\n", Executer::execAndGetResponse(SystemInfoCommands::CMD_TEMP_CPU));
		return $temps[count($temps) - 1];
	}

	public function getStorages() : array {
		$disks = explode("\n", Executer::execAndGetResponse(SystemInfoCommands::CMD_STORAGES));
		$rslt = [];
		array_shift($disks);
		foreach ($disks as $diskRaw) {
			$disk = preg_split("/[\s,]+/", $diskRaw);
			if (
				empty($disk[0])
				|| in_array($disk[0], $this->skipStorageFormats)
				|| in_array($disk[1], $this->skipMountPoints)
			) continue;

			$rslt[$disk[1]] = [
				'caption' => $disk[1],
				'size' => $disk[2],
				'available' => $disk[3],
				'used' => $disk[4],
			];
		}
		sort($rslt);
		return $rslt;
	}

	public function getCpuLoad() {
		return round(Executer::execAndGetResponse(SystemInfoCommands::CMD_CPU_LOAD), 2);
	}

	public function getCpuFrequency() : int {
		return round(
			Executer::execAndGetResponse(SystemInfoCommands::CMD_CPU_FREQUENCY)
		);
	}

	public function getMemory() : MemoryInfo {
		$memory = explode(' ', Executer::execAndGetResponse(SystemInfoCommands::CMD_MEMORY));
		$memoryInfo = new MemoryInfo();
		$memoryInfo->setUsed($memory[1]);
		$memoryInfo->setTotal($memory[0]);
		return $memoryInfo;
	}

	public function getProcessList() : array {
		$processes = explode(
			"\n",
			Executer::execAndGetResponse(SystemInfoCommands::CMD_PROCESSLIST)
		);
		$rslt = [];
		$header = array_shift($processes);
		$header = explode('|', trim($header));
		$header = array_flip($header);

		foreach ($processes as $process) {
			$cols = explode('|', trim($process));
			if (substr($cols[$header['RES']], -1) == 'g') {
				$cols[$header['RES']] = $this->convertTpsGtoKilobytes($cols[$header['RES']]);
			}

			$rslt[] = [
				'cpu' => $cols[$header['%CPU']],
				'memory' => Miscellaneous::bytesToHuman(
					((int)$cols[$header['RES']] - (int)$cols[$header['SHR']]) * 1024
				),
				'user' => $cols[$header['USER']],
				'cmd' => $cols[$header['COMMAND']],
			];
		}
		return $rslt;
	}

	public function isLockedScreen() : bool {
		return Executer::execAndGetResponse(SystemInfoCommands::CMD_ISLOCKEDSCREEN) == 1;
	}

	public function getGpuName() : string {
		return Executer::execAndGetResponse(SystemInfoCommands::CMD_GPUNAME);
	}

	public function getCpuName() : string {
		return Executer::execAndGetResponse(SystemInfoCommands::CMD_CPUNAME);
	}

	public function getUptime() : string {
		return Executer::execAndGetResponse(SystemInfoCommands::CMD_UPTIME);
	}

	public function getKernelVersion() : string {
		return Executer::execAndGetResponse(SystemInfoCommands::CMD_KERNELVERSION);
	}

	public function getDistro() : string {
		return Executer::execAndGetResponse(SystemInfoCommands::CMD_DISTRO);
	}

	public function getGpuInfo() : GpuSystemInfo {
		$raw = Executer::execAndGetResponse(GraphicNvidia::CMD_GETINFO);
		$values = explode(',', $raw);
		$gpu = new GpuSystemInfo();
		$gpu->setTemperature((int)$values[0] == $values[0] ? (int)$values[0] : 0);
		if (count($values) == 4) {
			$gpu->setLoad((int)$values[1]);
			$gpu->setMemoryFree($values[3]);
			$gpu->setMemoryTotal($values[2]);
		}
		return $gpu;
	}

	private function convertTpsGtoKilobytes(string $gbs) : int {
		return (int)((float)str_replace(
			',', '.', $gbs
		) * 1024 * 1024);
	}

}
