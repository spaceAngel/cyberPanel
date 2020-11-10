<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Applications;

class PingCommand extends BaseCommand {

	const PING_HOST = '8.8.8.8';
	const TIMEOUT_MARK_AS_DISCONNECT = 1.7;

	const REGEXP_PARSE_TIMEOUT = '/.*time=([0-9.]*) ([a-z]{1,2})/';

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
		$lastTouch = microtime(TRUE) - filemtime(self::$file);
		clearstatcache();
		$output = file(self::$file);
		$output = array_slice($output, -10);
		$parsed = [];
		preg_match(self::REGEXP_PARSE_TIMEOUT, $output[count($output) - 1], $parsed);

		$output = implode('', $output);
		return [
			'pings' => $output,
			'disconnected' => $lastTouch > self::TIMEOUT_MARK_AS_DISCONNECT,
			'time' => $parsed[2] == 's' ? (float)$parsed[1] * 1000 : (float)$parsed[1],
		];
	}

}
