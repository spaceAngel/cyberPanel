<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;

class DateTime extends BaseCommand{

	public function run() : array {
		return [
			'time' => date('H:i:s'),
			'date' => date('m.d.Y')
		];
	}
}
