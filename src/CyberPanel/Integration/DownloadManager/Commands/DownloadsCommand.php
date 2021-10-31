<?php

namespace CyberPanel\Integration\DownloadManager\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Utils\Miscellaneous;
use CyberPanel\Integration\DownloadManager\DownloadManager;

class DownloadsCommand extends BaseCommand{

	public function run() : array {
		$rslt = [];
		foreach (DownloadManager::getInstance()->getDownloads() as $download) {
			$rslt[] = [
				'filename' => $download->getFilename(),
				'bytesReceived' => Miscellaneous::bytesToHuman($download->getDownloaded()),
				'bytesTotal' => Miscellaneous::bytesToHuman($download->getTotal()),
				'estimatedInterval' => $download->getCalculatedInterval(),
				'speed' => Miscellaneous::bytesToHuman($download->getCalculatedSpeed() * 1024),
				'downloaded' => $download->getDownloadedPercent(),
				'isInterrupted' => $download->getisInterrupted(),
			];
		}
		return [
			'downloads' => $rslt
		];
	}
}
