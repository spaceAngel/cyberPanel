<?php

namespace CyberPanel\Integration\IcuMonitor;

use CyberPanel\Commands\CommandResolver;
use CyberPanel\Integration\Mail\Commands\StoreMailsCommand;
use CyberPanel\Integration\Mail\Commands\GetMailsCommand;
use CyberPanel\Configuration\ConfigurationLoader as ConfLoader;
use CyberPanel\Environment;
use CyberPanel\Integration\IcuMonitor\Commands\StoreValuesCommand;
use CyberPanel\Integration\IcuMonitor\Commands\GetValuesCommand;
use CyberPanel\Integration\IcuMonitor\Configuration\ConfigurationLoader;
use CyberPanel\System\Executer;
use CyberPanel\Logging\Log;
use CyberPanel\Configuration\Configuration;


class IcuMonitorModule {

	private function __construct() {
	}

	public static function init() : void {
		CommandResolver::getInstance()->registerCommand(
			'icumonitor.values.store', StoreValuesCommand::class
		);

		CommandResolver::getInstance()->registerCommand(
			'icumonitor.values.get', GetValuesCommand::class
		);

		ConfLoader::registerSubLoader(
			'icuMonitor',
			ConfigurationLoader::class
		);

		self::runPyBridge();
	}

	private static function runPyBridge() : void {
		$ip = Configuration::getInstance()->getSubSection('icuMonitor')->getIp();
		Log::info('Starting pyIcuBridge for monitor %s', [$ip]);
		Executer::exec(
			self::buildCommand($ip, Environment::getInstance()->getPort())
		);
	}

	private static function buildCommand(
		string $monitorIp,
		string $localSocketPort
	) : string {
		return __DIR__ . DIRECTORY_SEPARATOR
		. 'pyBridge' . DIRECTORY_SEPARATOR
		. 'pyBridge.py ' . $monitorIp . ' ' . $localSocketPort;
	}

}
