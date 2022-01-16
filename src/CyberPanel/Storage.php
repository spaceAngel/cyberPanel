<?php

namespace CyberPanel;

class Storage {

	protected static self $instance;

	protected array $storage = [];

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function get(string $key) {
		if (array_key_exists($key, $this->storage)) {
			return $this->storage[$key];
		}
		return NULL;
	}

	public function set(string $key, $value) : void {
		$this->storage[$key] = $value;
	}
}
