<?php

namespace CyberPanel\Commands;

use CyberPanel\Commands\Commands\DateTimeCommand;
use CyberPanel\Commands\Commands\SystemInfoCommand;
use CyberPanel\Commands\Commands\LoadMacrosCommand;
use CyberPanel\Commands\Commands\RunMacroCommand;
use CyberPanel\Commands\Commands\KeyboardCommand;
use CyberPanel\Commands\Commands\MediaCommand;

class CommandParser {

	private static $instance;

	private $commands = [];

	private function __construct() {
		$this->registerCommand('datetime', DateTimeCommand::class);
		$this->registerCommand('systeminfo', SystemInfoCommand::class);
		$this->registerCommand('loadmacros', LoadMacrosCommand::class);
		$this->registerCommand('macro', RunMacroCommand::class);
		$this->registerCommand('keyboard', KeyboardCommand::class);
		$this->registerCommand('media', MediaCommand::class);
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
