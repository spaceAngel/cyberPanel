<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\DataStructs\Download;

class StoreDownloadsCommand extends BaseCommand{

	protected static $storedDownloads = [];

	public function run() : array {
		self::$storedDownloads = [];
		foreach ($this->parameters as $parameter) {
			$download = new Download();
			$download->setFilename($parameter->filename);
			$download->setTotal($parameter->bytesTotal);
			$download->setDownloaded($parameter->bytesReceived);
			$download->setEstimatedEndTime(
				new \DateTime($parameter->estimatedEndTime ?? NULL )
			);
			self::$storedDownloads[] = $download;
		}

		return [];
	}

	public static function getStoredDownloads() {
		return self::$storedDownloads;
	}
}
