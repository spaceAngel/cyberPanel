<?php

namespace CyberPanel\Commands\Commands;


use CyberPanel\Collector\Collectors\DateTimeCollector;
use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;

class DateTimeCommand extends BaseCommand{

	public function run() : array {
		return (array)Storage::getInstance()->get(
			DateTimeCollector::getStorageVariableName()
		);
	}
}
