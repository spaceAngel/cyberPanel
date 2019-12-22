<?php

namespace CyberPanel\Configuration;

class Configuration {

	private static $instance;

	private $configuration;

	private $macroList;

	private $systemLimits;

	private function __construct() {
		$this->systemLimits  = new SystemLimits();
	}

	public static function getInstance(): self {
		if (empty(self::$instance)) {
			self::$instance = new self();
			ConfigurationLoader::load(self::$instance);
		}
		return self::$instance;
	}

	public function genMacros() : array {
		return $this->configuration['macros'];
	}

	public function addMacroList(MacroList $macroList) {
		$this->macroList = $macroList;
	}

	public function getMacroList() : MacroList {
		return $this->macroList;
	}

	public function getSystemLimits() : SystemLimits {
		return $this->systemLimits;
	}
}
