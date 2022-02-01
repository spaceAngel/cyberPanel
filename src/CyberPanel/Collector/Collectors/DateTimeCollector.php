<?php

namespace CyberPanel\Collector\Collectors;

use CyberPanel\Collector\CollectorInterface;
use CyberPanel\Utils\DateTime;

use Carbon\Carbon;

class DateTimeCollector implements CollectorInterface {

	public static function getStorageVariableName() : string {
		return 'datetime';
	}

	public function getTicks() : int {
		return 1;
	}

	public function collect() : array {
		$datetime = Carbon::now();
		return [
			'time' => $datetime->format('H:i:s'),
			'date' => $datetime->format('l d.m.Y'),
			'holiday' => DateTime::getHoliday(
				(int)$datetime->format('m'),
				(int)$datetime->format('d')
			),
		];
	}
}
