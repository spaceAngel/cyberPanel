<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;
use CyberPanel\Collector\Collectors\UpsCollector;

class UpsStateCommand extends BaseCommand {

	public function run() : array {
		return (array)Storage::getInstance()->get(
			UpsCollector::getStorageVariableName()
		);
	}
}
