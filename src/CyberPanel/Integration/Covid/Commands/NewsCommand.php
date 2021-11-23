<?php

namespace CyberPanel\Integration\Covid\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Integration\Covid\Parsers\IdnesOnlineNews;

class NewsCommand extends BaseCommand {

	public function run() : array {
		$idnesNews = new IdnesOnlineNews();
		return [
			'news' => $idnesNews->getNews(),
		];
	}


}
