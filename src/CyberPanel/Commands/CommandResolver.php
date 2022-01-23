<?php

namespace CyberPanel\Commands;

use CyberPanel\Commands\Commands\DateTimeCommand;
use CyberPanel\Commands\Commands\SystemInfoCommand;
use CyberPanel\Commands\Commands\KeyboardCommand;
use CyberPanel\Commands\Commands\MediaCommand;
use CyberPanel\Commands\Commands\LockScreenImageCommand;
use CyberPanel\Commands\Commands\HwInfoCommand;
use CyberPanel\Commands\Commands\KeyPressCommand;
use CyberPanel\Commands\Commands\OpenInBrowserCommand;
use CyberPanel\Commands\Commands\NetworkCommand;
use CyberPanel\Commands\Commands\FileManagerCommand;
use CyberPanel\Commands\Commands\UpsStateCommand;
use CyberPanel\Logging\Log;
use CyberPanel\Commands\Commands\StorageCommand;
use CyberPanel\Macros\Commands\LoadMacrosCommand;
use CyberPanel\Macros\Commands\RunMacroCommand;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use CyberPanel\Macros\Commands\MacrosEnabledListCommand;

class CommandResolver {

	private static $instance;

	private $commands = [];

	private function __construct() {
		$this->registerCommand('datetime', DateTimeCommand::class);
		$this->registerCommand('systeminfo', SystemInfoCommand::class);
		$this->registerCommand('hwinfo', HwInfoCommand::class);
		$this->registerCommand('keyboard', KeyboardCommand::class);
		$this->registerCommand('media', MediaCommand::class);
		$this->registerCommand('lockscreenimage', LockScreenImageCommand::class);
		$this->registerCommand('keypress', KeyPressCommand::class);
		$this->registerCommand('openbrowser', OpenInBrowserCommand::class);
		$this->registerCommand('network', NetworkCommand::class);
		$this->registerCommand('files', FileManagerCommand::class);
		$this->registerCommand('upsstatus', UpsStateCommand::class);
		$this->registerCommand('storage', StorageCommand::class);
		$this->registerCommand('loadmacros', LoadMacrosCommand::class);
		$this->registerCommand('macro', RunMacroCommand::class);
		$this->registerCommand('macros.enabled', MacrosEnabledListCommand::class);
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function parse($commandQuery) : array {
		if (!is_array($commandQuery)) {
			$commandQuery = [$commandQuery];
		}
		$commands = [];
		foreach ($commandQuery as $commandQuery) {
			if (
				!empty($commandQuery->command)
				&& array_key_exists($commandQuery->command, $this->commands)
			) {
				$parameters = $commandQuery->parameters ?? [];
				if (is_object($parameters)) {
					$parameters = get_object_vars($parameters);
				}
				$command = new $this->commands[$commandQuery->command](
					$commandQuery->command,
					!empty($parameters) ? $parameters : []
				);
				$commands[] = $command;
			} else {
				Log::error('Unknown command %s', [$commandQuery->command]);
			}
		}
		return $commands;
	}

	public function registerCommand(string $command, string $class) : void {
		$this->commands[$command] = $class;
	}
}
