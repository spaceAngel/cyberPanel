<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;

class StoreDownloadsCommand extends BaseCommand{

	protected static $storedDownloads = [];

	public function run() : array {
		self::$storedDownloads = $this->parameters;
		return [];
	}

	public static function getStoredDownloads() {
		return self::$storedDownloads;
	}
}
