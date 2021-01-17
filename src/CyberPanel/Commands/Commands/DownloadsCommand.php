<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;

class DownloadsCommand extends BaseCommand{

	public function run() : array {
		$rslt = [];
		foreach (StoreDownloadsCommand::getStoredDownloads() as $download) {
			$rslt[] = [
				'filename' => $download->getFilename(),
				'bytesReceived' => $download->getDownloaded(),
				'bytesTotal' => $download->getTotal(),
				'estimatedEndTime' => $download->getEstimatedEndTime(),
			];
		}
		return [
			'downloads' => $rslt
		];
	}
}
