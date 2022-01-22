<?php

namespace CyberPanel\Macros;

class Librarian {

	protected static self $instance;

	protected $records = [];

	private function __construct() {
		$this->loadLibraries();
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	protected function loadLibraries() : void {
		$basePath = __DIR__ . DIRECTORY_SEPARATOR . 'Libraries';
		$libraries = dir($basePath);
		while (FALSE !== ($file = $libraries->read())) {
			$filenameParsed = pathinfo($basePath . $file);
			if ($filenameParsed['extension'] == 'php') {
				$this->records = array_merge(
					$this->records,
					require_once $basePath . DIRECTORY_SEPARATOR . $file
				);
			}
		}
	}

	public function getMacroFromLibrary(string $key) : array {
		return $this->records[$key] ?? [];
	}
}
