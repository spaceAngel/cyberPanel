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

	private ?string $subIconImage = NULL;

	private ?string $notification = NULL;

	private $checkEnabledFunction = NULL;

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

	public function setSubIconImage(string $subIconImage) : self {
		$this->subIconImage = $subIconImage;
		return $this;
	}

	public function getSubIconImage() : ?string {
		return $this->subIconImage;
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

	public function setNotification(string $notification) : self {
		$this->notification = $notification;
		return $this;
	}

	public function getNotification() : ?string {
		return $this->notification;
	}

	public function setCheckEnabledFunction(callable $checkEnabledFunction) : self {
		$this->checkEnabledFunction = $checkEnabledFunction;
		return $this;
	}

	public function getCheckEnabledFunction() : ?callable {
		return $this->checkEnabledFunction;
	}
}
