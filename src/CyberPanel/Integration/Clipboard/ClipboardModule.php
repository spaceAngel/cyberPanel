<?php

namespace CyberPanel\Integration\Clipboard;

use CyberPanel\Commands\CommandResolver;
use CyberPanel\Integration\Clipboard\Commands\GetClipboardHistoryCommand;
use CyberPanel\Collector\Collector;
use CyberPanel\Integration\Clipboard\Commands\SetClipboardContentCommand;

class ClipboardModule {

	private function __construct() {
	}

	public static function init() : void {
		CommandResolver::getInstance()->registerCommand(
			'clipboard.history', GetClipboardHistoryCommand::class
		);
		CommandResolver::getInstance()->registerCommand(
			'clipboard.set', SetClipboardContentCommand::class
		);

		Collector::getInstance()->registerCollector(ClipboardCollector::class);
	}
}
