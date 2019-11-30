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
}
