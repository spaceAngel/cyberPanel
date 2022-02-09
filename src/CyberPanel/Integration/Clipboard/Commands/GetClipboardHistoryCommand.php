<?php

namespace CyberPanel\Integration\Clipboard\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;
use CyberPanel\Integration\Clipboard\ClipboardCollector;

class GetClipboardHistoryCommand extends BaseCommand {

	public function run() : array {
		return [
			Storage::getInstance()->get(
				ClipboardCollector::getStorageVariableName()
			)
		];
	}


}
