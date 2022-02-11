<?php

namespace CyberPanel\Integration\Media;

use CyberPanel\Commands\CommandResolver;
use CyberPanel\Integration\Media\Commands\MediaCommand;

class MediaModule {

	private function __construct() {
	}

	public static function init() : void {
		CommandResolver::getInstance()->registerCommand(
			'media', MediaCommand::class
		);
	}



}
