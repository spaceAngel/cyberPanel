<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\DataStructs\Download;
use CyberPanel\Integration\DownloadManager;

class StoreDownloadsCommand extends BaseCommand{

	protected static $storedDownloads = [];

	public function run() : array {
		$downloads = [];
		foreach ($this->parameters as $parameter) {
			$download = new Download();
			$download->setFilename($parameter->filename);
			$download->setTotal($parameter->bytesTotal);
			$download->setDownloaded($parameter->bytesReceived);
			$download->setId($parameter->id);
			$download->setIsInterrupted((bool) $parameter->interrupted);
			$download->setEstimatedEndTime(
				new \DateTime($parameter->estimatedEndTime ?? NULL )
			);
			$downloads[] = $download;
		}

		DownloadManager::getInstance()->storeDownloads($this->getConnection(), $downloads);
		return [];
	}

	public static function getStoredDownloads() {
		return self::$storedDownloads;
	}
}
