<?php

namespace CyberPanel\Integration\PublicTransport;

use CyberPanel\Configuration\ConfigurationLoader as ConfLoader;
use \CyberPanel\Integration\PublicTransport\Configuration\ConfigurationLoader;

class PublicTransportModule {

	private function __construct() {
	}

	public static function init() : void {
		ConfLoader::registerSubLoader(
			'departures',
			ConfigurationLoader::class
		);

	}

}
