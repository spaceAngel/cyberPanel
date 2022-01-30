<?php

namespace CyberPanel\Collector\Collectors;

use CyberPanel\Collector\CollectorInterface;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Applications;
use CyberPanel\System\Network;
use CyberPanel\Utils\Miscellaneous;

class NetworkCollector implements CollectorInterface {

	protected const PING_HOST = '8.8.8.8';
	protected const TIMEOUT_MARK_AS_DISCONNECT = 1.7;
	protected const REGEXP_PARSE_TIMEOUT = '/.*time=([0-9.]*) ([a-z]{1,2})/';

	protected $file;

	protected $publicIp;
	protected $publicIpLastCheck;

	public function __construct() {
		if (empty($this->file)) {
			$this->file = tempnam(sys_get_temp_dir(), 'ping');
			Executer::exec(
				sprintf(Applications::CMD_PING, self::PING_HOST)
				. '>> ' . $this->file
			);
		}
	}

	public static function getStorageVariableName() : string {
		return 'network';
	}

	public function getTicks() : int {
		return 1;
	}

	public function collect() : array {
		$pings = $this->handlePing();
		$lastTime = microtime(TRUE) - filemtime($this->file);
		return [
			'ip' => [
				'local' => Network::getInstance()->getLocalIp(),
				'public' => $this->handlePublicIp(),
				'gateway' => Network::getInstance()->getGatewayIp(),
				'dns' => Network::getInstance()->getDnsIp(),
				'mac' => Network::getInstance()->getMac(),
			],
			'pings' => implode('', $pings),
			'disconnected' => $lastTime > self::TIMEOUT_MARK_AS_DISCONNECT,
			'time' => $this->getTimeoutFromPings($pings),
			'traffic' => $this->getTraffic()
		];
	}

	protected function getTraffic() : array {
		$traffic = Network::getInstance()->getTraffic();
		return [
			'download' => Miscellaneous::bytesToHuman($traffic->getDownload() * 1000),
			'upload' => Miscellaneous::bytesToHuman($traffic->getUpload() * 1000),
		];
	}

	protected function handlePing() : array {
		clearstatcache();
		$output = file_exists($this->file) ? file($this->file) : [];
		$output = is_array($output) ? $output : [];
		$output = array_slice($output, -10);
		return $output;
	}

	protected function getTimeoutFromPings(array $pings) : float {
		$parsed = [];
		if (count($pings) > 1) {
			preg_match(self::REGEXP_PARSE_TIMEOUT, $pings[count($pings) - 1], $parsed);
		}

		if (count($parsed) >= 2 && $parsed[2] == 's') {
			return (float)$parsed[1] * 1000;
		} elseif (count($parsed) >= 2) {
			return (float)$parsed[1];
		}
		return 9999;
	}

	protected function isOfflineByLastTouch() : bool {
		return microtime(TRUE) - filemtime($this->file) > self::TIMEOUT_MARK_AS_DISCONNECT;
	}

	protected function handlePublicIp() {
		if (time() > $this->publicIpLastCheck + 30) {
			$isOffline = $this->isOfflineByLastTouch();
			$this->publicIp = (!$isOffline) ? Network::getInstance()->getPublicIp() : NULL;
			$this->publicIpLastCheck = time();
		}
		return $this->publicIp;
	}

}
