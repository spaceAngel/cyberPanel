<?php

namespace CyberPanel\Integration\IcuMonitor\Configuration;

class Configuration {

	protected string $ip;

	public function getIp() : string {
		return $this->ip;
	}

	public function setIp(string $ip) : void {
		$this->ip = $ip;
	}

}
