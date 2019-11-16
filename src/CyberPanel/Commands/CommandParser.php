<?php

namespace CyberPanel\Commands;

use CyberPanel\Commands\Commands\DateTime;

class CommandParser {

	private static $instance;

	private $commands = [];

	private function __construct() {
		$this->registerCommand('datetime', DateTime::class);

	}

	public static function getInstance() : CommandParser {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function parse(object $command) : Command {
		if (
			!empty($command->command)
			&& array_key_exists($command->command, $this->commands)
		) {
			$command = new $this->commands[$command->command](
				$command->command, !empty($command->parameters) ? $command->parameters : NULL
			);
			return $command;
		}
	}

	public function registerCommand(string $command, string $class) : void {
		$this->commands[$command] = $class;
	}
}
