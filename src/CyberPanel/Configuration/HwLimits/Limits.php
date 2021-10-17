<?php

namespace CyberPanel\Configuration\HwLimits;

class Limits {

	private Cpu $cpu;
	private Gpu $gpu;

	private const DEFAULT_MEMORY = 14 * 1024 * 1024 * 1024;
	private int $memory = self::DEFAULT_MEMORY;

	private const DEFAULT_STORAGE = 30;
	private int $storage = self::DEFAULT_STORAGE;

	public function __construct() {
		$this->cpu = new Cpu();
		$this->gpu = new Gpu();
	}

	public function getCpu() : Cpu {
		return $this->cpu;
	}

	public function getGpu() : Gpu {
		return $this->gpu;
	}

	public function setMemory(int $memory) : void {
		$this->memory = $memory;
	}

	public function getMemory() : int {
		return $this->memory;
	}

	public function setStorage(int $storage) : void {
		$this->storage = $storage;
	}

	public function getStorage() : int {
		return $this->storage;
	}

}
