<?php

namespace CyberPanel\Utils\Traits;

use CyberPanel\Environment;

use WebSocket\Client;
use WebSocket\ConnectionException;

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

	protected function sendToSocketServer(array $request) : void {
		try {
			if (empty($this->client)) {
				$this->builSocketClient();
			}
			$this->client->text(
				json_encode($request)
			);
		} catch (ConnectionException $e) { // failed connection -> rebuild Socket Client
			$this->builSocketClient();
			$this->sendToSocketServer($request);
		}

	}
}
