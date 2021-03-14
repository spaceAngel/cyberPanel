<?php

namespace CyberPanel\Configuration;

class Configuration {

	private static $instance;

	private $configuration;

	private $systemLimits;

	private string $lastFmApiKey;

	private array $clients;

	private array $sidebarWidgets = [];

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

	public function getSystemLimits() : SystemLimits {
		return $this->systemLimits;
	}

	public function getLastFmApiKey() : string {
		return $this->lastFmApiKey;
	}

	public function setLastFmApiKey(string $apiKey) : void {
		$this->lastFmApiKey = $apiKey;
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
}

