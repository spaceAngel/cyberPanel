<?php

namespace CyberPanel\Integration\IcuMonitor;

class ValueStorage {

	private static $instance;

	protected ?int $spo2 = NULL;
	protected ?int $spo2Pulse = NULL;

	protected $ecgPulse = NULL;

	protected ?int $nbpSys = NULL;
	protected ?int $nbpDias = NULL;
	protected ?int $nbpMean = NULL;
	protected ?int $nbpInflating = NULL;
	protected ?int $nbpMeasureTimestamp = NULL;

	protected ?int $respiratoryRate = NULL;

	protected ?int $refreshRate = 500;

	public function reset(): void {
		$this->spo2 = NULL;
		$this->spo2Pulse = NULL;
		$this->nbpSys = NULL;
		$this->nbpDias = NULL;
		$this->nbpMean = NULL;
		$this->nbpInflating = NULL;
		$this->nbpMeasureTimestamp = NULL;
		$this->ecgPulse = NULL;
		$this->respiratoryRate = NULL;
	}

	public function getSpo2(): ?int {
		return $this->spo2;
	}

	public function setSpo2(int $spo2): void {
		$this->spo2 = $this->cleanValue($spo2);
	}

	public function getSpo2Pulse(): ?int {
		return $this->spo2Pulse;
	}

	public function setSpo2Pulse(int $spo2Pulse): void {
		$this->spo2Pulse = $this->cleanValue($spo2Pulse);
	}

	public function getNbpSys(): ?int {
		return $this->nbpSys;
	}

	public function setNbpSys(int $nbpSys): void {
		$this->nbpSys = $this->cleanValue($nbpSys);
	}

	public function getNbpDias(): ?int {
		return $this->nbpDias;
	}

	public function setNbpDias(int $nbpDias): void {
		$this->nbpDias = $this->cleanValue($nbpDias);
	}

	public function getNbpMean(): ?int {
		return $this->nbpMean;
	}

	public function setNbpMean(int $nbpMean): void {
		$this->nbpMean = $this->cleanValue($nbpMean);
	}

	public function getNbpInflating(): ?int {
		return $this->nbpInflating;
	}

	public function setNbpInflating(int $nbpInflating): void {
		$this->nbpInflating = $this->cleanValue($nbpInflating);
	}


	public function getEcgPulse(): ?int {
		return $this->ecgPulse;
	}

	public function setEcgPulse(int $ecgPulse): void {
		$this->ecgPulse = $this->cleanValue($ecgPulse);
	}

	public function getRespiratoryRate(): ?int {
		return $this->respiratoryRate;
	}

	public function setRespiratoryRate(int $respiratoryRate): void {
		$this->respiratoryRate = $this->cleanValue($respiratoryRate);
	}

	public function setNbpTimestamp(int $timestamp = NULL): void {
		$this->nbpMeasureTimestamp = $timestamp;
	}

	public function getNbpTimestamp(): ?int {
		return $this->nbpMeasureTimestamp;
	}

	public function setRefreshRate(int $refreshRate): void {
		$this->refreshRate = $refreshRate;
	}

	public function getRefreshRate(): int {
		return $this->refreshRate;
	}

	private function __construct() {
	}

	public static function getInstance(): self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	protected function cleanValue($value) {
		if ($value == 8388607) {
			return NULL;
		}
		return $value;
	}

}
