<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Collector\Collectors\HwCollector;
use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;

class HwInfoCommand extends BaseCommand {

	public function run() : array {
		return (array)Storage::getInstance()->get(
			HwCollector::getStorageVariableName()
		);
	}

}
