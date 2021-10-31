<?php

namespace CyberPanel\Integration\DownloadManager;

use CyberPanel\Commands\CommandResolver;
use CyberPanel\Integration\DownloadManager\Commands\StoreDownloadsCommand;
use CyberPanel\Integration\DownloadManager\Commands\DownloadsCommand;

class DownloadManagerModule {

	private function __construct() {
	}

	public static function init() : void {
		CommandResolver::getInstance()->registerCommand(
			'storeDownloads', StoreDownloadsCommand::class
		);
		CommandResolver::getInstance()->registerCommand(
			'downloads', DownloadsCommand::class
		);
	}
}
