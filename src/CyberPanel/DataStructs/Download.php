<?php

namespace CyberPanel\DataStructs;

class Download {

	private string $filename;
	private int $downloaded;
	private int $total;
	private $estimatedEndTime;

	public function getFilename() {
		return $this->filename;
	}

	public function getDownloaded() {
		return $this->downloaded;
	}

	public function getTotal() {
		return $this->total;
	}

	public function getEstimatedEndTime() {
		return $this->estimatedEndTime;
	}

	public function setFilename($filename) {
		$this->filename = $filename;
	}

	public function setDownloaded($downloaded) {
		$this->downloaded = $downloaded;
	}

	public function setTotal($total) {
		$this->total = $total;
	}

	public function setEstimatedEndTime($estimatedEndTime) {
		$this->estimatedEndTime = $estimatedEndTime;
	}

}
