<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;

class StorageCommand extends BaseCommand {

	public function run() : array {
		if (count((array)$this->parameters) == 1) {
			return Storage::getInstance()->get($this->parameters['key']);
		} elseif (count($this->parameters) == 2) {
			Storage::getInstance()->set(
				$this->parameters['key'],
				$this->parameters['value']
			);
		}
		return [];
	}

}
