<?php

namespace CyberPanel\Configuration;

class SystemLimits {

	const DEFAULT_TEMP_CPU = 25;
	const DEFAULT_TEMP_GPU = 50;

	private $tempCpu = self::DEFAULT_TEMP_CPU;

	private $tempGpu = self::DEFAULT_TEMP_GPU;

	public function getTempCpu() : int {
		return $this->tempCpu;
	}

	public function getTempGpu() : int {
		return $this->tempGpu;
	}

	public function setTempCpu(int $tempCpu = self::DEFAULT_TEMP_CPU) {
		$this->tempCpu = $tempCpu;
	}

	public function setTempGpu(int $tempGpu = self::DEFAULT_TEMP_GPU) {
		$this->tempGpu = $tempGpu;
	}

}
