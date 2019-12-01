<?php

namespace CyberPanel;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use CyberPanel\WsServer as CyberpanelSocketServer;

class CyberPanel {

	const DEFAULT_PORT = 8081;

	private static $instance;

	private $socketServer;

	private $options;

	private function __construct() {
		$this->init();
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
			$this->getPort()
		);

		$this->socketServer->run();
	}

	private function getPort() : int {
		if (array_key_exists('p', $this->options)) {
			return (int)$this->options['p'];
		} elseif (array_key_exists('port', $this->options)) {
			return (int)$this->options['port'];
		}
		return self::DEFAULT_PORT;
	}

	private function init() {
		$this->options = getopt(
			'p::',
			['port::']
		);
	}

}
