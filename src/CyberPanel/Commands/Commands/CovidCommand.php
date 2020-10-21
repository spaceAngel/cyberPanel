<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Covid\News;
use CyberPanel\Covid\Stats\Summary;
use CyberPanel\Covid\Stats\HospitalCapacities;

class CovidCommand extends BaseCommand {

	protected $news;

	protected $stats;

	protected $hospitalCapacities;

	public function __construct(string $invokingCommand, array $parameters = []) {
		parent::__construct($invokingCommand, $parameters);
		$this->news = new News();
		$this->stats = new Summary();
		$this->hospitalCapacities = new HospitalCapacities();
	}

	public function run() : array {
		return [
			'news' => $this->news->getNews(),
			'stats' => $this->stats->getStats(),
			'hospitalCapacities' => $this->hospitalCapacities->getCapacities(),
		];
	}

	protected function parseMzcrStats() : array {
	}

}
