<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Applications;

class PingCommand extends BaseCommand {

	const PING_HOST = '8.8.8.8';

	protected static $file;
	public function __construct(string $invokingCommand, array $parameters = []) {
		parent::__construct($invokingCommand, $parameters);
		if (empty(self::$file)) {
			self::$file = tempnam(sys_get_temp_dir(), 'ping');
			Executer::exec(
				sprintf(Applications::CMD_PING, self::PING_HOST)
				. '>> ' . self::$file
			);
		}
	}

	public function run() : array {
		$output = file(self::$file);
		$output = array_slice($output, -10);
		$output = implode('', $output);
		return [$output];
	}

}
