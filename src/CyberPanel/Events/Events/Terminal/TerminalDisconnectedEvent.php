<?php

namespace CyberPanel\Events\Events\Terminal;

use CyberPanel\Events\Event;

class TerminalDisconnectedEvent extends Event {

	private string $remoteAddress;

	public function __construct(string $remoteAddress) {
		$this->remoteAddress = $remoteAddress;

	}

	public function getRemoteAddress(): string {
		return $this->remoteAddress;
	}
}
