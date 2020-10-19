<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Covid\News;

class CovidCommand extends BaseCommand {

	// phpcs:disable Generic.Files.LineLength

	const URL_MZCR_STATS = 'https://onemocneni-aktualne.mzcr.cz/api/v2/covid-19/zakladni-prehled.json';
	// phpcs::enable

	protected $news;

	public function __construct(string $invokingCommand, array $parameters = []) {
		parent::__construct($invokingCommand, $parameters);
		$this->news = new News();
	}

	public function run() : array {
		return [
			'news' => $this->news->getNews(),
			'stats' => $this->parseMzcrStats(),
		];
	}

	protected function parseMzcrStats() : array {
		$raw = file_get_contents(self::URL_MZCR_STATS);
		$json = json_decode($raw);
		$data = $json->data[0];

		return [
				'cases' => [
						'today' => $data->potvrzene_pripady_dnesni_den,
						'yesterday' => $data->potvrzene_pripady_vcerejsi_den,
						'total' => $data->aktivni_pripady
				],
				'tests' => $data->provedene_testy_vcerejsi_den,
				'hospitalised' => $data->aktualne_hospitalizovani,
				'deaths' => $data->umrti,
		];
	}

}
