<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;
use CyberPanel\Collector\Collectors\SystemStateCollector;

class SystemInfoCommand extends BaseCommand {

	public function run() : array {
		return (array)Storage::getInstance()->get(
			SystemStateCollector::getStorageVariableName()
		);
	}

}
