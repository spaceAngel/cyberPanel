<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Utils\DateTime;

class DateTimeCommand extends BaseCommand{

	public function run() : array {
		return [
			'time' => date('H:i:s'),
			'date' => date('l d.m.Y'),
			'holiday' => DateTime::getHoliday(
				(int)date('m'),
				(int)date('d')
			),
		];
	}
}
