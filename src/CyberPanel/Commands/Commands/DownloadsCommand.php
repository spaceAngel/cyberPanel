<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Utils\Miscellaneous;

class DownloadsCommand extends BaseCommand{

	public function run() : array {
		$rslt = [];
		foreach (StoreDownloadsCommand::getStoredDownloads() as $download) {
			$rslt[] = [
				'filename' => $download->getFilename(),
				'bytesReceived' => Miscellaneous::bytesToHuman($download->getDownloaded()),
				'bytesTotal' => Miscellaneous::bytesToHuman($download->getTotal()),
				'estimatedInterval' => $download->getCalculatedInterval(),
				'speed' => Miscellaneous::bytesToHuman($download->getCalculatedSpeed() * 1024),
				'downloaded' => $download->getDownloadedPercent(),
			];
		}
		return [
			'downloads' => $rslt
		];
	}
}
