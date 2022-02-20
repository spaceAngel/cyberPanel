<?php

namespace CyberPanel\Integration\News\Configuration;

class ConfigurationLoader {

	public static function load(array $yaml) : Configuration {
		$configuration = new Configuration;
		foreach ($yaml as $news) {
			$configuration->addSource($news);
		}
		return $configuration;
	}
}
