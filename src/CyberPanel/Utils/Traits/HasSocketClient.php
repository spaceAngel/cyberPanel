<?php

namespace CyberPanel\Utils\Traits;

use CyberPanel\Environment;

use WebSocket\Client;

trait HasSocketClient {

	private Client $client;

	protected function builSocketClient() : void {
		$this->client = new \WebSocket\Client(
			"ws://127.0.0.1:" . Environment::getInstance()->getPort()
		);
	}

	protected function getSocketClient() : Client {
		return $this->client;
	}
}
