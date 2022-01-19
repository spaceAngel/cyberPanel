<?php

namespace CyberPanel\Macros;

class Macro {

	private $icon;

	private $caption;

	private $command;

	private string $position = 'left';

	private bool $isDelimiter = FALSE;

	private bool $isSpace = FALSE;

	private ?string $iconImage = NULL;

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

	public function setIconImage(string $iconImage) : self {
		$this->iconImage = $iconImage;
		return $this;
	}

	public function getIconImage() : ?string {
		return $this->iconImage;
	}

	public function setPosition(string $position) : self {
		$this->position = $position;
		return $this;
	}

	public function getPosition() : string {
		return $this->position;
	}

	public function getIsSpace() : bool {
		return $this->isSpace();
	}

	public function setIsSpace(bool $isSpace = TRUE) : self {
		$this->isSpace = $isSpace;
		return $this;
	}
}
