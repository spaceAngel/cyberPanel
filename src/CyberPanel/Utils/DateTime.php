<?php

namespace CyberPanel\Utils;

class DateTime {

	private static $holidays;

	public static function getHoliday(int $month, int $day) : string {
		if (empty(self::$holidays)) {
			self::$holidays = require_once __DIR__ . DIRECTORY_SEPARATOR . 'holidays.dat.php';
		}

		return self::$holidays[$month][$day];
	}

	public static function secondsToHuman(int $value) : string {
		$minutes = floor($value / 60);
		$seconds = ($value % 60);
		$hours = 0;
		if ($minutes >= 60) {
			$hours = floor($minutes / 60);
			$minutes = $minutes % 60;
		}
		$rslt = '';
		if ($hours > 0) {
			$rslt .= (string)$hours . ':';
		}
		$rslt .= ($minutes < 10 ? '0' : '') . $minutes . ':';
		$rslt .= ($seconds < 10 ? '0' : '') . $seconds;
		return $rslt;
	}

	public static function humanToMicrotime(string $human, bool $dayBefore = FALSE) : int {
		$human = str_replace('O', '0', $human);
		$date = new \DateTime($human);
		if ($dayBefore) {
			$date->modify('-1 day');
		}
		return $date->getTimestamp();
	}

	public static function microtimeToHuman(int $timestamp = NULL) : string {
		return date('Y-m-d H:i', $timestamp);
	}
}
