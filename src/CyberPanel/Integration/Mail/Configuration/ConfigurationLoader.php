<?php

namespace CyberPanel\Integration\Mail\Configuration;

class ConfigurationLoader {

	public static function load(array $yaml) : Configuration {
		$configuration = new Configuration;
		$configuration->setHost($yaml['host']);
		$configuration->setPort($yaml['port']);
		$configuration->setUsername($yaml['username']);
		return $configuration;
	}
}
