<?php

namespace CyberPanel\Configuration;

use CyberPanel\Configuration\HwLimits\Cpu;
use CyberPanel\Configuration\HwLimits\Gpu;

class SystemLimits {

	private Cpu $cpu;
	private Gpu $gpu;

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

}
