<?php

namespace CyberPanel\Covid;


use CyberPanel\Covid\NewsParsers\IdnesOnlineNews;
use CyberPanel\Covid\NewsParsers\Parser;

class News {

	protected $idnesNews;

	protected $parsers = [];

	public function __construct() {
		$this->parsers = [
			new IdnesOnlineNews()
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

		return $articles;
	}
}