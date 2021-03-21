<?php

namespace CyberPanel\Configuration\HwLimits;

class Cpu {

	private const DEFAULT_TEMP = 25;
	private int $temperature = self::DEFAULT_TEMP;

	public function setTemperature(int $temperature) : void {
		$this->temperature = $temperature;
	}

	public function getTemperature() : int {
		return $this->temperature;
	}
}
