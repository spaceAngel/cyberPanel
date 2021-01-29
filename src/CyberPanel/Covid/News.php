<?php

namespace CyberPanel\Covid;

use CyberPanel\Covid\NewsParsers\IdnesOnlineNews;
use CyberPanel\Covid\NewsParsers\Parser;
use CyberPanel\Covid\NewsParsers\RssNews;
use CyberPanel\Covid\NewsParsers\Ct24News;

class News {

	const URL_RSS_ECDC = 'https://www.ecdc.europa.eu/en/taxonomy/term/2942/feed';

	protected $parsers = [];

	public function __construct() {
		$this->parsers = [
			new RssNews(self::URL_RSS_ECDC),
			new IdnesOnlineNews(),
			new Ct24News()
		];
	}

	public function getNews() : array {
		$articles = [];
		foreach ($this->parsers as $parser) {
			if ($parser instanceof Parser) {
				$articles = array_merge(
					$articles,
					$parser->getNews()
				);
			}
		}
		usort($articles, function($a, $b) {
			return $b['microtime'] <=> $a['microtime'];
		});
		return $articles;
	}
}
