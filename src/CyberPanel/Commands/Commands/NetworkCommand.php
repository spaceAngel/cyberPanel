<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Applications;
use CyberPanel\System\Network;
use CyberPanel\Utils\Miscellaneous;

class NetworkCommand extends BaseCommand {

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
		if (empty($this->parameters)) {
			return $this->handlePing();
		} else {
			return $this->handleIps();
		}
	}

	protected function handleIps() : array {
		return [
			'ip' => [
				'local' => Network::getInstance()->getLocalIp(),
				'public' => Network::getInstance()->getPublicIp(),
				'gateway' => Network::getInstance()->getGatewayIp(),
				'dns' => Network::getInstance()->getDnsIp(),
				'mac' => Network::getInstance()->getMac(),
			]
		];
	}

	protected function handlePing() {
		$lastTouch = microtime(TRUE) - filemtime(self::$file);
		clearstatcache();
		$output = file_exists(self::$file) ? file(self::$file) : [];
		$output = is_array($output) ? $output : [];
		$output = array_slice($output, -10);

		$parsed = [];
		if (count($output) > 1) {
			preg_match(self::REGEXP_PARSE_TIMEOUT, $output[count($output) - 1], $parsed);
		}

		if (count($parsed) >= 2 && $parsed[2] == 's') {
			$time = (float)$parsed[1] * 1000;
		} elseif (count($parsed) >= 2) {
			$time = (float)$parsed[1];
		}
		$traffic = Network::getInstance()->getTraffic();
		return [
			'pings' => implode('', $output),
			'disconnected' => $lastTouch > self::TIMEOUT_MARK_AS_DISCONNECT,
			'time' => !empty($time) ? $time : 9999,
			'traffic' => [
				'download' => Miscellaneous::bytesToHuman($traffic->getDownload() * 1000),
				'upload' => Miscellaneous::bytesToHuman($traffic->getUpload() * 1000),
			]
		];
	}

	protected function isOfflineByLastTouch() : bool {
		return microtime(TRUE) - filemtime(self::$file) > self::TIMEOUT_MARK_AS_DISCONNECT;
	}

}
