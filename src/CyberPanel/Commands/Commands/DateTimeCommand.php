<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;

class DateTimeCommand extends BaseCommand{

	public function run() : array {
		return [
			'time' => date('H:i:s'),
			'date' => date('l d.m.Y')
		];
	}
}
