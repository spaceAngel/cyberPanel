<?php

namespace CyberPanel\Integration\Mail;

class MailManager {

	protected array $folders = [];

	private static self $instance;

	private float $quota = 0;

	private bool $errorOnConnect = FALSE;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function storeFolders(array $folders) : void {
		$this->folders = $folders;
	}

	public function getFolders() : array {
		return $this->folders;
	}

	public function getUnreadCount() : int {
		$rslt = 0;
		foreach ($this->getFolders() as $folder) {
			$rslt += $folder->unread;
		}
		return $rslt;
	}

	public function setQuota(float $quota) : void {
		$this->quota = $quota;
	}

	public function getQuota() : float {
		return $this->quota;
	}

	public function setErrorOnConnect(bool $errorOnConnect = TRUE) : void {
		$this->errorOnConnect = $errorOnConnect;
	}

	public function getErrorOnConnect() : bool {
		return $this->errorOnConnect;
	}

}
