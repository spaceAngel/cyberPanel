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
		$configuration->getSystemLimits()->getGpu()->setTemperature($gpu['temperature']);

	}

	private static function parseMacro(array $data) : Macro {
		return MacroParser::getInstance()->parse($data);
	}

}
