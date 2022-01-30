<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Collector\Collectors\NetworkCollector;
use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;

class NetworkCommand extends BaseCommand {

	public function run() : array {
		return (array)Storage::getInstance()->get(
			NetworkCollector::getStorageVariableName()
		);
	}

}
