<?php

namespace CyberPanel\Integration\Clipboard;

use CyberPanel\Collector\CollectorInterface;

class ClipboardCollector implements CollectorInterface {

	public function getTicks() : int {
		return 2;
	}

	public static function getStorageVariableName() : string {
		return 'clipboard';
	}

	public function collect() : array {
		return Clipboard::getHistory();
	}

}
