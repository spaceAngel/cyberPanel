<?php

namespace CyberPanel\Integration\IcuMonitor\Configuration;

class ConfigurationLoader {

	public static function load(array $yaml) : Configuration {
		$configuration = new Configuration;
		$configuration->setIp($yaml['ip']);
		return $configuration;
	}
}
