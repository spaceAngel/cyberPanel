<?php

namespace CyberPanel\Configuration\HwLimits;

class Cpu {

	private const DEFAULT_TEMP = 25;
	private int $temperature = self::DEFAULT_TEMP;

	private const DEFAULT_LOAD = 80;
	private int $load = self::DEFAULT_LOAD;

	public function setTemperature(int $temperature) : void {
		$this->temperature = $temperature;
	}

	public function getTemperature() : int {
		return $this->temperature;
	}

	public function setLoad(int $load) : void {
		$this->load = $load;
	}

	public function getLoad() : int {
		return $this->load;
	}
}
