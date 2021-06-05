<?php


namespace CyberPanel\DataStructs\System;

class Fan {

	protected int $speed;

	protected int $max = 0;

	protected int $min = PHP_INT_MAX;

	public function set(int $speed) : void {
		$this->speed = $speed;
		$this->max = max($this->max, $speed);
		$this->min = min($this->min, $speed);
	}

	public function getSpeed() : int {
		return $this->speed;
	}

	public function getMax() : int {
		return $this->max;
	}

	public function getMin() : int {
		return $this->min;
	}

	public function getUtilisation() : int {
		if ($this->max - $this->min == 0) {
			return 1;
		} else {
			return (int) (($this->speed - $this->min) * 100 / ($this->max - $this->min));
		}
	}
}
