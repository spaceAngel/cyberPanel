<?php

namespace CyberPanel\DataStructs\System;

class NetworkTraffic {

	private float $download = 0;
	private float $upload = 0;

	public function getDownload() : float {
		return $this->download;
	}

	public function getUpload() : float {
		return $this->upload;
	}

	public function setDownload(float $download) : void {
		$this->download = $download;
	}

	public function setUpload(float $upload) : void {
		$this->upload = $upload;
	}

}
