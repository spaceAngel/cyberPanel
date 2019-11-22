<?php

namespace CyberPanel\Configuration;

class Macro {

	private $icon;

	private $caption;

	private $command;

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

	public function getHash() : string {
		return spl_object_hash($this);
	}

	public function getCommand() {
		return $this->command;
	}

	public function setCommand(string $command) {
		$this->command = $command;
		return $this;
	}

}
