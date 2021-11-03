<?php

namespace CyberPanel\Configuration;

use Symfony\Component\Yaml\Yaml;
use CyberPanel\Macros\MacroManager;
use CyberPanel\Macros\Macro;
use CyberPanel\Macros\MacroParser;

class ConfigurationLoader {

	protected static $subLoaders = [];

	public static function registerSubLoader(string $sectionName, $loader) {
		self::$subLoaders[$sectionName] = $loader;
	}

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
		$configuration->setClients($yaml['clients']);
		$configuration->setSidebarWidgets($yaml['sidebar']);
		$configuration->setMainPanels($yaml['mainpanel']);
		self::loadApiKeys($yaml, $configuration);
		if (!empty($yaml['ups'])) {
			self::configureUps($yaml['ups'], $configuration);
		}
		if (!empty($yaml['geolocation'])) {
			self::configureGeoLocation($yaml['geolocation'], $configuration);
		}
		self::loadSubConfigurations($yaml, $configuration);

	}

	private static function configureGeolocation(
		array $yaml,
		Configuration $configuration
	) : void {
		$configuration->getGeoLocation()->setLatitude($yaml['latitude']);
		$configuration->getGeoLocation()->setLongitude($yaml['longitude']);
	}

	private static function loadApiKeys(
		array $yaml,
		Configuration $configuration
	) : void {
		if (array_key_exists('keys', $yaml)) {
			foreach ($yaml['keys'] as $name => $key) {
				Configuration::getInstance()->setApiKey($name, $key);
			}
		}
	}

	private static function loadSubConfigurations(
		array $yaml,
		Configuration $configuration
	) : void {
		foreach (self::$subLoaders as $configurationKey => $subLoader) {
			if (array_key_exists($configurationKey, $yaml)) {
				$configuration->setSubSection(
					$configurationKey,
					$subLoader::load($yaml[$configurationKey])
				);
			}
		}
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
		$configuration->getSystemLimits()->setStorage($yaml['storage']);
	}

	private static function configureUps(
		array $yaml,
		Configuration $configuration
	) {
		$configuration->getUps()->setName($yaml['name']);
	}

	private static function parseMacro(array $data) : Macro {
		return MacroParser::getInstance()->parse($data);
	}

}
