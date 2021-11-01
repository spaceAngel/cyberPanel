<?php

namespace CyberPanel\Configuration;

use CyberPanel\Configuration\HwLimits\Limits;
use CyberPanel\Configuration\Misc\Ups;

class Configuration {

	private static $instance;

	private $configuration;

	private $systemLimits;

	private array $clients;

	private $ups;

	private array $sidebarWidgets = [];

	private array $mainPanels = [];

	private array $subConfigurations = [];

	private array $apiKeys = [];

	private function __construct() {
		$this->systemLimits  = new Limits();
		$this->ups = new Ups();
	}

	public function setApiKey(string $name, string $key) : void {
		$this->apiKeys[$name] = $key;
	}

	public function getApiKey(string $name) : ?string {
		if (array_key_exists($name, $this->apiKeys)) {
			return $this->apiKeys[$name];
		}
		return NULL;
	}

	public function setSubSection(string $key, object $subSection) : void {
		$this->subConfigurations[$key] = $subSection;
	}

	public function getSubSection(string $key) {
		if (array_key_exists($key, $this->subConfigurations)) {
			return $this->subConfigurations[$key];
		}
	}

	public static function getInstance(): self {
		if (empty(self::$instance)) {
			self::$instance = new self();
			ConfigurationLoader::load(self::$instance);
		}
		return self::$instance;
	}

	public function getSystemLimits() : Limits {
		return $this->systemLimits;
	}

	public function setClients(array $clients) : void {
		$this->clients = $clients;
	}

	public function getClients() : array {
		return array_merge(
			$this->clients,
			['127.0.0.1']
		);
	}

	public function getSidebarWidgets() : array {
		return $this->sidebarWidgets;
	}

	public function setSidebarWidgets(array $sidebarWidgets = []) : void {
		$this->sidebarWidgets = $sidebarWidgets;
	}

	public function getMainPanels() : array {
		return $this->mainPanels;
	}

	public function setMainPanels(array $mainPanels = []) : void {
		$this->mainPanels = $mainPanels;
	}

	public function getUps() : Ups {
		return $this->ups;
	}
}

