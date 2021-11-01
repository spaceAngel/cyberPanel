<?php

namespace CyberPanel\Integration\PublicTransport\Configuration;

class Configuration {

	protected array $departures = [];

	public function addDeparture(string $departure) : void {
		$this->departures[] = $departure;
	}

	public function getDepartures() : array {
		return $this->departures;
	}

}
