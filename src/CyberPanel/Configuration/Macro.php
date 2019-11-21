<?php

namespace CyberPanel\Configuration;

class Macro {

	private $icon;

	private $caption;

	public function getIcon() {
		return $this->icon;
	}

	public function getCaption() {
		return $this->caption;
	}

	public function setIcon($icon) {
		$this->icon = $icon;
		return $this;
	}

	public function setCaption($caption) {
		$this->caption = $caption;
		return $this;
	}



}
