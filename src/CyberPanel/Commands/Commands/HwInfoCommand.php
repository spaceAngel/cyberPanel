<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;
use CyberPanel\System\SystemDataCollector;

class HwInfoCommand extends BaseCommand {

	public function run() : array {
		return (array)Storage::getInstance()->get(
			SystemDataCollector::STORAGEKEY_HWINFO
		);
	}

}
