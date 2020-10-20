<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Covid\News;
use CyberPanel\Covid\Stats\Summary;

class CovidCommand extends BaseCommand {

	protected $news;

	protected $stats;

	public function __construct(string $invokingCommand, array $parameters = []) {
		parent::__construct($invokingCommand, $parameters);
		$this->news = new News();
		$this->stats = new Summary();
	}

	public function run() : array {
		return [
			'news' => $this->news->getNews(),
			'stats' => $this->stats->getStats(),
		];
	}

	protected function parseMzcrStats() : array {
	}

}
