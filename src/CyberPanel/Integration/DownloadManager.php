<?php

namespace CyberPanel\Integration;

use Ratchet\ConnectionInterface;
use CyberPanel\Events\EventManager;
use CyberPanel\Events\Events\DownloadManager\DownloadCompletedEvent;
use CyberPanel\Events\Events\DownloadManager\DownloadInterruptedEvent;

class DownloadManager {

	private static self $instance;

	protected $downloads = [];

	protected $downloadsOld = [];

	private function __construct() {

	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function storeDownloads(
		ConnectionInterface $connection,
		array $downloads
	) : void {
		if (!array_key_exists($connection->resourceId, $this->downloads)) {
			$this->downloads[$connection->resourceId] = [];
		}
		$ids = [];
		foreach ($downloads as $download) {
			if (
				$download->getIsInterrupted()
				&& !$this->downloads[$connection->resourceId][$download->getId()]->getIsInterrupted()
			) {
				EventManager::getInstance()->event(
					new DownloadInterruptedEvent($download)
				);
			}
			$this->downloads[$connection->resourceId][$download->getId()] = $download;
			$ids[] = $download->getId();
		}
		foreach ($this->downloads[$connection->resourceId] as $id => $download) {
			if (!in_array($id, $ids)) {
				EventManager::getInstance()->event(
					new DownloadCompletedEvent($download)
				);
				unset($this->downloads[$connection->resourceId][$id]);
			}
		}
	}

	public function getDownloads() : array {
		$rslt = [];
		foreach ($this->downloads as $connectionDownloads) {
			$rslt = array_merge($rslt, $connectionDownloads);
		}
		return $rslt;
	}

}
