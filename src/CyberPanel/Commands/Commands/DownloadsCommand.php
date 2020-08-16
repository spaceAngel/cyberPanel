<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;

class DownloadsCommand extends BaseCommand{

	public function run() : array {
		return [
			'downloads' => StoreDownloadsCommand::getStoredDownloads()
		];
	}
}
