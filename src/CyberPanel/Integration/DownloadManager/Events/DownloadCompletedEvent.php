<?php

namespace CyberPanel\Integration\DownloadManager\Events;

use CyberPanel\Events\Event;
use CyberPanel\DataStructs\Download;

class DownloadCompletedEvent extends Event {

	protected Download $download;

	public function __construct(Download $download) {
		$this->download = $download;
	}

	public function getDownload() : Download {
		return $this->download;
	}
}
