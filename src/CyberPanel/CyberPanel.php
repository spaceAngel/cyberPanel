<?php

namespace CyberPanel;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use CyberPanel\WsServer as CyberpanelSocketServer;

class CyberPanel {

	private static $instance;

	private $socketServer;

	private function __construct() {
	}

	public static function run() {
		if (empty(self::$instance)) {
			self::$instance = new self();
			self::$instance->runSocketServer();
		}
		return self::$instance;
	}

	private function runSocketServer() {
		$this->socketServer = IoServer::factory(
			new HttpServer(
				new WsServer(
					new CyberpanelSocketServer()
				)
			),
			8080
		);

		$this->socketServer->run();
	}

}
