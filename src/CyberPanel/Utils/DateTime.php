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

	public static function humanToMicrotime(string $human, bool $dayBefore = FALSE) : int {
		$human = str_replace('O', '0', $human);
		$date = new \DateTime($human);
		if ($dayBefore) {
			$date->modify('-1 day');
		}
		return $date->getTimestamp();
	}
}
