<?php

namespace CyberPanel\Integration\Covid;

use CyberPanel\Commands\CommandResolver;
use CyberPanel\Integration\Covid\Commands\NewsCommand;


class CovidModule {

	private function __construct() {
	}

	public static function init() : void {
		CommandResolver::getInstance()->registerCommand(
			'covid.news', NewsCommand::class
		);
	}

}
