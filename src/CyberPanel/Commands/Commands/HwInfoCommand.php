<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;
use CyberPanel\Collector\Collector;

class HwInfoCommand extends BaseCommand {

	public function run() : array {
		return (array)Storage::getInstance()->get(
			Collector::STORAGEKEY_HWINFO
		);
	}

}
