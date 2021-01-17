<?php

namespace CyberPanel\DataStructs\System;

class MemoryInfo {

	private int $total;
	private int $used;

	public function getTotal() : int {
		return $this->total;
	}

	public function getUsed() : int {
		return $this->used;
	}

	public function setTotal(int $total) : void {
		$this->total = $total;
	}

	public function setUsed(int $used) : void {
		$this->used = $used;
	}

	public function getLoad() : float {
		return $this->getUsed() * 100 / $this->getTotal();
	}


}
