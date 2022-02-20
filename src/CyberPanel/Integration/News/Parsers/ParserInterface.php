<?php

namespace CyberPanel\Integration\News\Parsers;

interface ParserInterface {

	public function getNews(string $source) : array;

}
