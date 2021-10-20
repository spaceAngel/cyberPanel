<?php

namespace CyberPanel\Events\Events\DownloadManager;

use CyberPanel\Events\Event;
use CyberPanel\DataStructs\Download;

class DownloadInterruptedEvent extends Event {

	protected Download $download;

	public function __construct(Download $download) {
		$this->download = $download;
	}

	public function getDownload() : Download {
		return $this->download;
	}
}
