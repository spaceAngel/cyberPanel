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
		$temperaturesLimits = $yaml['systemLimits']['temperatures'];
		$configuration->getSystemLimits()->setTempCpu($temperaturesLimits['cpu']);
		$configuration->getSystemLimits()->setTempGpu($temperaturesLimits['gpu']);
		$configuration->setLastFmApiKey($yaml['keys']['lastfm']);
		$configuration->setClients($yaml['clients']);
		$configuration->setSidebarWidgets($yaml['sidebar']);
		$configuration->setMainPanels($yaml['mainpanel']);
	}

	private static function parseMacro(array $data) : Macro {
		return MacroParser::getInstance()->parse($data);
	}

}
