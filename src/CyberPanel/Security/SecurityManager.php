<?php

namespace CyberPanel\Security;

use Ratchet\ConnectionInterface;
use Psr\Http\Message\ServerRequestInterface;
use CyberPanel\Configuration\Configuration;

class SecurityManager {

	private static self $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function checkHttpAccess(ServerRequestInterface $request) : bool {
		return in_array(
			$request->getServerParams()['REMOTE_ADDR'],
			Configuration::getInstance()->getClients()
		);
	}

	public function checkSocketAccess(ConnectionInterface $connection) : bool {
		return in_array(
			$connection->remoteAddress,
			Configuration::getInstance()->getClients()
		);
	}
}
