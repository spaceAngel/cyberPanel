<?php

namespace CyberPanel\System;

use CyberPanel\System\ShellCommands\Ups as UpsCommands;
use CyberPanel\DataStructs\System\UpsStatus;
use CyberPanel\Configuration\Configuration;

class Ups {

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new Self();
		}
		return self::$instance;
	}

	public function getUpsStatus() : ?UpsStatus {
		$statusRaw = Executer::execAndGetResponse(
			sprintf(
				UpsCommands::CMD_STATUS,
				Configuration::getInstance()->getUps()->getName()
			)
		);
		$statusLines = explode("\n", $statusRaw);
		if (count($statusLines) == 1) {
			return NULL;
		}
		$status = new UpsStatus();
		foreach ($statusLines as $lineRaw) {
			$line = explode(':', $lineRaw);
			$this->handleStatusLine($line, $status);
		}

		return $status;
	}

	protected function handleStatusLine(array $line, UpsStatus $status) : void {
		switch ($line[0]) {
			case 'battery.charge':
				$status->setCharge((int)$line[1]);
				break;
			case 'battery.runtime':
				$status->setRuntime((int)$line[1]);
				break;
			case 'ups.load':
				$status->setLoad((int)$line[1]);
				break;
			case 'ups.realpower.nominal':
				$status->setRealpower((int)$line[1]);
				break;
			case 'ups.status':
				$status->setStatus((string)$line[1]);
				break;
		}
	}
}
