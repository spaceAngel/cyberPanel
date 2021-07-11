<?php

namespace CyberPanel\Configuration\Misc;

class Ups {

	private const DEFAULT_NAME = 'ups';
	private string $name = self::DEFAULT_NAME;

	public function setName(string $name) : void {
		$this->name = $name;
	}

	public function getName() : string {
		return $this->name;
	}
}
