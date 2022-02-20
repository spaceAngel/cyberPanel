<?php

namespace CyberPanel\Integration\News\Configuration;

class Configuration {

	protected array $newsSources = [];

	public function addSource(string $source) : void {
		$this->newsSources[] = $source;
	}

	public function getSources() : array {
		return $this->newsSources;
	}

}
