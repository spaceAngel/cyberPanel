<?php

namespace CyberPanel\Macros;

use CyberPanel\System\Executer;

class MacroManager {

	private $macros = [];

	private static self $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return  self::$instance;
	}

	public function addMacro(Macro $macro) {
		$this->macros[$macro->getHash()] = $macro;
		return $this;
	}

	public function getMacros() {
		return $this->macros;
	}

	public function runMacro(string $macroHash) : void {
		$macro = $this->macros[$macroHash];
		if ($macro->getCommand()) {
			Executer::exec($macro->getCommand());
		}
	}

}
