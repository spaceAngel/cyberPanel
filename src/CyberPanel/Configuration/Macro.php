<?php

namespace CyberPanel\Configuration;

class Macro {

	private $icon;

	private $caption;

	private $command;

	private bool $isDelimiter = FALSE;

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

	public function getIsDelimiter() : bool {
		return $this->isDelimiter;
	}

	public function setisDelimiter(bool $isDelimiter = TRUE) : self {
		$this->isDelimiter = $isDelimiter;
		return $this;
	}
}
