<?php

namespace CyberPanel;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use CyberPanel\WsServer as CyberpanelSocketServer;
use CyberPanel\Server\WebServer;
use CyberPanel\Logging\Log;

class CyberPanel {

	const DEFAULT_PORT = 8081;

	private static $instance;

	private $socketServer;

	private $webServer;

	private $options;

	private function __construct() {
		$this->init();
		$this->handleInfoSwitches();
		$this->checkForLogingSettings();
		Log::info('Starting CyberPanel version %s', [$this->getVersion()]);
		if ($this->isRunningAsDaemon()) {
			$this->daemonize();
		}
	}

	public static function run() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
			if (0 !== pcntl_fork()) {
				self::$instance->runSocketServer();
			} else {
				self::$instance->runWebServer();
			}
		}
		return self::$instance;
	}

	private function checkForLogingSettings() {
		if ($this->isRunningWithSwitch('v', 'verbose')) {
			Log::enableConsoleOutput();
		}
	}

	private function handleInfoSwitches() {
		if ($this->isRunningWithSwitch('V', 'version')) {
			$this->println($this->getVersion());
			exit();
		}
		if ($this->isRunningWithSwitch('h', 'help')) {
			echo $this->getHelp();
			exit();
		}
	}

	private function runSocketServer() {
		$this->socketServer = IoServer::factory(
			new HttpServer(
				new WsServer(
					new CyberpanelSocketServer()
				)
			),
			$this->getPort()
		);
		Log::info('Starting socket server on port %s', [$this->getPort()]);
		$this->socketServer->run();
	}

	private function runWebServer() {
		$this->webServer = new WebServer();
		Log::info('Starting webserver');
		$this->webServer->run();
	}

	private function getPort() : int {
		if (array_key_exists('p', $this->options)) {
			return (int)$this->options['p'];
		} elseif (array_key_exists('port', $this->options)) {
			return (int)$this->options['port'];
		}
		return self::DEFAULT_PORT;
	}

	private function isRunningAsDaemon() : bool {
		return array_key_exists('d', $this->options)
		|| array_key_exists('daemonized', $this->options);
	}

	private function init() : void {
		$this->options = getopt(
			'p::d::v::h::V::',
			['port::', 'daemonise', 'version', 'help', 'verbose']
		);
	}

	private function daemonize() {
		if (0 !== pcntl_fork()) {
			exit;
		}
	}

	private function isRunningWithSwitch(string $short, string $long) : bool {
		return array_key_exists($short, $this->options)
		|| array_key_exists($long, $this->options);
	}

	public static function getVersion() : string {
		return '1.0.0-beta';
	}

	private function println(string $str) : void {
		echo $str . "\n";
	}

	private function getHelp() : string {
		return file_get_contents(__DIR__ . '/help.txt');
	}

}
