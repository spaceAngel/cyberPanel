<?php

namespace CyberPanel\System;

class SystemInfo {

	// phpcs:disable Generic.Files.LineLength
	const CMD_TEMP_CPU = "sensors|sed -E -n '/[0-9]:.*\+[0-9]+\.[0-9]°[CF]/!b;s:\.[0-9]*°[CF].*$::;s:^.*\+::;p'";
	// phpcs:enable
	const CMD_TEMP_GPU = 'nvidia-smi --query-gpu=temperature.gpu --format=csv,noheader';


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
}
