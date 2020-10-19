<?php

namespace CyberPanel\Covid;


use CyberPanel\Covid\NewsParsers\IdnesOnlineNews;

class News {

	protected $idnesNews;

	public function __construct() {
		$this->idnesNews = new IdnesOnlineNews();
	}

	public function getNews() : array {
		$articles = array_merge(
			$this->idnesNews->getNews()
		);
		return $articles;
	}
}