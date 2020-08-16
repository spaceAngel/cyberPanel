<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Utils\DateTime;

class DownloadsCommand extends BaseCommand{

	public function run() : array {
		return [
			'downloads' => StoreDownloadsCommand::getStoredDownloads()
		];
	}
}
