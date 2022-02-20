<?php

namespace CyberPanel\Integration\News;

use CyberPanel\Collector\CollectorInterface;
use CyberPanel\Configuration\Configuration;
use CyberPanel\Integration\News\Parsers\ParserResolver;

class NewsCollector implements CollectorInterface {

	public function getTicks() : int {
		return 60 * 5;
	}

	public static function getStorageVariableName() : string {
		return 'news';
	}

	public function collect() : array {
		$news = [];
		foreach (Configuration::getInstance()->getSubSection('news')->getSources() as $source) {
			$news = array_merge(
				$news,
				ParserResolver::getParser($source)->getNews($source)
			);
		}
		$this->sort($news);
		return $news;
	}

	protected function sort(array &$news) : void {
		usort(
			$news,
			function ($a, $b) {
				return $a['microtime'] < $b['microtime'];
			}
		);
	}

}

