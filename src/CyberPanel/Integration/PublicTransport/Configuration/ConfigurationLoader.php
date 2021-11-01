<?php

namespace CyberPanel\Integration\PublicTransport\Configuration;

class ConfigurationLoader {

	public static function load(array $yaml) : Configuration {
		$configuration = new Configuration;
		foreach ($yaml as $departure) {
			$configuration->addDeparture($departure);
		}
		return $configuration;
	}
}
