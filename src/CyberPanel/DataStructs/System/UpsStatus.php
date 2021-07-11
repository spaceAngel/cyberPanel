<?php

namespace CyberPanel\DataStructs\System;

class UpsStatus {

	protected ?int $load = NULL;

	protected ?int $realpower = NULL;

	protected ?int $runtime = NULL;

	protected ?int $charge = NULL;

	protected ?string $status = NULL;

	public function getLoad() : int {
		return $this->load;
	}

	public function getLoadInWatts() : ?int {
		return $this->getRealpower() * ($this->getLoad() / 100);
	}

	public function getRealpower() : ?int {
		return $this->realpower;
	}

	public function getRuntime() : ?int {
		return $this->runtime;
	}

	public function getCharge() : ?int {
		return $this->charge;
	}

	public function getStatus() : ?string {
		return $this->status;
	}

	public function setLoad(int $load) : void {
		$this->load = $load;
	}

	public function setRealpower(int $realpower) : void {
		$this->realpower = $realpower;
	}

	public function setRuntime(int $runtime) : void {
		$this->runtime = $runtime;
	}

	public function setCharge(int $charge) : void {
		$this->charge = $charge;
	}

	public function setStatus(string $status) : void {
		$this->status = $status;
	}

}
