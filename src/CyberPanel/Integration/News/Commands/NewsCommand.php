<?php

namespace CyberPanel\Integration\News\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;
use CyberPanel\Integration\News\NewsCollector;

class NewsCommand extends BaseCommand{

	public function run() : array {
		return [
			'news' => Storage::getInstance()->get(
				NewsCollector::getStorageVariableName()
			)
		];
	}

}
