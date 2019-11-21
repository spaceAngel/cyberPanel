<?php

namespace CyberPanel\Configuration;

class MacroList {

	private $macros = [];

	public function addMacro(Macro $macro) {
		$this->macros[] = $macro;
		return $this;
	}

	public function getMacros() {
		return $this->macros;
	}


}
