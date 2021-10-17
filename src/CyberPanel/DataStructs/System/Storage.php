<?php

namespace CyberPanel\DataStructs\System;

final class Storage {

	protected string $name;

	protected int $size;

	protected int $used;

	protected int $available;

	public function getName() : string {
		return $this->name;
	}

	public function getSize() : int {
		return $this->size;
	}

	public function getUsed() : int {
		return $this->used;
	}

	public function setName(string $name) : void {
		$this->name = $name;
	}

	public function setSize(int $size) : void {
		$this->size = $size;
	}

	public function setUsed(int $used) : void {
		$this->used = $used;
	}

	public function getAvailable() : int {
		return $this->available;
	}

	public function setAvailable(int $available) : void {
		$this->available = $available;
	}

}
