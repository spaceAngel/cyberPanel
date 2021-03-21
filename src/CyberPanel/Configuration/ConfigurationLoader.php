<?php

namespace CyberPanel\Configuration;

use Symfony\Component\Yaml\Yaml;
use CyberPanel\Macros\MacroManager;
use CyberPanel\Macros\Macro;
use CyberPanel\Macros\MacroParser;

class ConfigurationLoader {
	public static function load(
		Configuration $configuration,
		string $fileName = 'config.yml'
	) : void {
		$yaml = Yaml::parseFile($fileName);
		foreach ($yaml['macros'] as $macro) {
			MacroManager::getInstance()->addMacro(
				self::parseMacro($macro)
			);
		}
		self::configureHwLimits($yaml['systemLimits'], $configuration);
		$configuration->setLastFmApiKey($yaml['keys']['lastfm']);
		$configuration->setClients($yaml['clients']);
		$configuration->setSidebarWidgets($yaml['sidebar']);
		$configuration->setMainPanels($yaml['mainpanel']);
	}

	private static function configureHwLimits(
		array $yaml,
		Configuration $configuration
	) : void {
		$cpu = $yaml['cpu'];
		$gpu = $yaml['gpu'];
		$configuration->getSystemLimits()->getCpu()->setTemperature($cpu['temperature']);
		$configuration->getSystemLimits()->getCpu()->setLoad($cpu['load']);
		$configuration->getSystemLimits()->getGpu()->setTemperature($gpu['temperature']);
		$configuration->getSystemLimits()->getGpu()->setLoad($gpu['load']);
		$configuration->getSystemLimits()->setMemory($yaml['memory'] * 1024 * 1024 * 1024);

	}

	private static function parseMacro(array $data) : Macro {
		return MacroParser::getInstance()->parse($data);
	}

}
