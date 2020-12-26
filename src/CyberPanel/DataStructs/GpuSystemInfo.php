<?php


namespace CyberPanel\DataStructs;

class GpuSystemInfo {

	private ?int $temperature;
	private ?int $load = NULL;
	private $memoryFree;
	private $memoryTotal;

	public function getLoad() : ?int {
		return $this->load;
	}

	public function setLoad(int $load) : void {
		$this->load = $load;
	}

	public function getMemoryFree() {
		return $this->memoryFree;
	}

	public function getMemoryTotal() {
		return $this->memoryTotal;
	}

	public function setTemperature(int $temperature) : void {
		$this->temperature = $temperature;
	}

	public function getTemperature() : int {
		return $this->temperature;
	}

	public function setMemoryFree($memoryFree) : void {
		$this->memoryFree = $memoryFree;
	}

	public function setMemoryTotal($memoryTotal) : void {
		$this->memoryTotal = $memoryTotal;
	}


}
