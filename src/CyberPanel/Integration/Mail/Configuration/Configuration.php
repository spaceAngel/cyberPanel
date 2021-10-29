<?php

namespace CyberPanel\Integration\Mail\Configuration;

class Configuration {

	protected string $username;

	protected string $host;

	protected string $port;

	public function getUsername() : string {
		return $this->username;
	}

	public function getHost() : string {
		return $this->host;
	}

	public function getPort() : string {
		return $this->port;
	}

	public function setUsername(string $username) : void {
		$this->username = $username;
	}

	public function setHost(string $host) : void {
		$this->host = $host;
	}

	public function setPort(string $port) : void {
		$this->port = $port;
	}

}
