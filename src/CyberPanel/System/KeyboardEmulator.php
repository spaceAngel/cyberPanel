<?php

namespace CyberPanel\System;


use CyberPanel\System\ShellCommands\KeyboardEmulator as commands;

class KeyboardEmulator {

	private static $instance;

	private function __construct() {
	}

	public static function getInstance(): self {
		if (empty ( self::$instance )) {
			self::$instance = new self ();
		}
		return self::$instance;
	}

	public function keyPress($key): void {
		Executer::execAndGetResponse(
			sprintf(commands::CMD_KEYPRESS, $key)
		);
	}
}
