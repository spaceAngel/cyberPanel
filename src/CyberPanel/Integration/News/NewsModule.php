<?php

namespace CyberPanel\Integration\News;

use CyberPanel\Configuration\ConfigurationLoader as ConfLoader;
use CyberPanel\Integration\News\Configuration\ConfigurationLoader;
use CyberPanel\Commands\CommandResolver;
use CyberPanel\Integration\News\Commands\NewsCommand;
use CyberPanel\Collector\Collector;

class NewsModule {

	private function __construct() {
	}

	public static function init() : void {
		ConfLoader::registerSubLoader(
			'news',
			ConfigurationLoader::class
		);

		CommandResolver::getInstance()->registerCommand(
			'news', NewsCommand::class
		);

		Collector::getInstance()->registerCollector(NewsCollector::class);

	}

}
