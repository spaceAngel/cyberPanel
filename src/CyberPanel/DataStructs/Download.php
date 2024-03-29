<?php

namespace CyberPanel\DataStructs;

use \DateTime;

class Download {

	private string $filename;
	private int $downloaded;
	private int $total;
	private ?DateTime $estimatedEndTime;
	private int $id;
	private bool $isInterupted = FALSE;

	public function getFilename() : string {
		return $this->filename;
	}

	public function getDownloaded() : int {
		return $this->downloaded;
	}

	public function getTotal() : int {
		return $this->total;
	}

	public function getEstimatedEndTime() : ?DateTime {
		return $this->estimatedEndTime;
	}

	public function setFilename(string $filename) : void {
		$this->filename = $filename;
	}

	public function setDownloaded(int $downloaded) : void {
		$this->downloaded = $downloaded;
	}

	public function setTotal($total) {
		$this->total = $total;
	}

	public function setEstimatedEndTime(\DateTime $estimatedEndTime = NULL) : void {
		$this->estimatedEndTime = $estimatedEndTime;
	}

	public function getRemain() : int {
		return ($this->getTotal() - $this->getDownloaded()) / 1024;
	}

	public function getCalculatedSpeed() : int {
		if (!empty($this->getEstimatedEndTime()) && $this->getCalculatedInterval() > 0) {
			return (int) $this->getRemain() / $this->getCalculatedInterval();
		}
		return 0;
	}

	public function getDownloadedPercent() {
		return 100 * ($this->getDownloaded() / $this->getTotal());
	}

	public function getCalculatedInterval() : int {
		if (!empty($this->getEstimatedEndTime())) {
			return (int)($this->getEstimatedEndTime()->getTimestamp() - time());
		}
		return 1;
	}

	public function setId(int $id) : void {
		$this->id = $id;
	}

	public function getId() : int {
		return $this->id;
	}

	public function setIsInterrupted(bool $isInterrupted) : void {
		$this->isInterupted = $isInterrupted;
	}

	public function getIsInterrupted() : bool {
		return $this->isInterupted;
	}

}
