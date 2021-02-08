<?php

namespace CyberPanel\System;

use CyberPanel\System\ShellCommands\Network as NetworkCommands;


class Network {

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new Self();
		}
		return self::$instance;
	}

	public function getLocalIp() : string {
		return Executer::execAndGetResponse(NetworkCommands::CMD_IP_LOCAL);
	}

	public function getPublicIp() : string {
		return Executer::execAndGetResponse(NetworkCommands::CMD_IP_PUBLIC);
	}

	public function getGatewayIp() : string {
		return Executer::execAndGetResponse(NetworkCommands::CMD_IP_GATEWAY);
	}

	public function getDnsIp() : string {
		return Executer::execAndGetResponse(NetworkCommands::CMD_IP_DNS);
	}

	public function getMac() : string {
		return Executer::execAndGetResponse(NetworkCommands::CMD_MAC);
	}

}
