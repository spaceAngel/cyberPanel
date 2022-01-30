<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;
use CyberPanel\Collector\Collectors\KeyboardCollector;

class KeyboardCommand extends BaseCommand {

	public function run() : array {
		return (array)Storage::getInstance()->get(
			KeyboardCollector::getStorageVariableName()
		);
	}

}
