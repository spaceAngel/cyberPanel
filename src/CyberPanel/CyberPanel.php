<?php

namespace CyberPanel;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use CyberPanel\WsServer as CyberpanelSocketServer;
use CyberPanel\Server\WebServer;
use CyberPanel\Logging\Log;
use CyberPanel\Voice\VoiceSubmodule;
use CyberPanel\Events\EventManager;
use CyberPanel\Events\Events\Runtime\ApplicationStartedEvent;
use CyberPanel\Integration\ModuleLoader;
use CyberPanel\System\SystemDataCollector;
use CyberPanel\System\ExternalScriptsRunner;

class CyberPanel {

	private static $instance;

	private $socketServer;

	private $webServer;

	private function __construct() {
		$this->init();
		$this->handleInfoSwitches();
		VoiceSubmodule::init();
		EventManager::getInstance()->event(new ApplicationStartedEvent());
		Log::info('Starting CyberPanel version %s', [$this->getVersion()]);
		if (Environment::getInstance()->getRunningWithDeamonizeSwitch()) {
			$this->daemonize();
		}
		SystemDataCollector::getInstance()->runCollector();
	}

	public static function run() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
			ModuleLoader::loadModules();
			if (0 !== pcntl_fork()) {
				ExternalScriptsRunner::getInstance()->runExecuter();
				self::$instance->runSocketServer();

			} else {
				self::$instance->runWebServer();
			}
		}
		return self::$instance;
	}

	private function checkForLogingSettings() {
		if (Environment::getInstance()->getRunningWithVerboseSwitch()) {
			Log::enableConsoleOutput();
		}
	}

	private function handleInfoSwitches() {
		if (Environment::getInstance()->getRunningWithVersionSwitch()) {
			$this->println($this->getVersion());
			exit();
		}
		if (Environment::getInstance()->getRunningWithHelpSwitch()) {
			echo $this->getHelp();
			exit();
		}
	}

	private function runSocketServer() {
		$port = Environment::getInstance()->getPort();
		try {
			$this->socketServer = IoServer::factory(
				new HttpServer(
					new WsServer(
						new CyberpanelSocketServer()
					)
				),
				$port
			);
			Log::info(
				'Starting socket server on port %s', [$port]
			);
			$this->socketServer->run();
		} catch (\RuntimeException $e) {
			Log::error(
				'Cannot run socket server. Port %s is already in use.', [$port]
			);
		}

	}

	private function runWebServer() {
		$this->webServer = new WebServer();
		Log::info('Starting webserver');
		$this->webServer->run();
	}

	private function init() : void {
		Environment::getInstance()->loadEnvironmentVariables();
		$this->checkForLogingSettings();
	}

	private function daemonize() {
		if (0 !== pcntl_fork()) {
			exit;
		}
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
