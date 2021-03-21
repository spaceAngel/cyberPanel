<?php

namespace CyberPanel\Configuration\HwLimits;

class Gpu {

	private const DEFAULT_TEMP = 50;
	private int $temperature = self::DEFAULT_TEMP;

	public function setTemperature(int $temperature) : void {
		$this->temperature = $temperature;
	}

	public function getTemperature() : int {
		return $this->temperature;
	}
}
