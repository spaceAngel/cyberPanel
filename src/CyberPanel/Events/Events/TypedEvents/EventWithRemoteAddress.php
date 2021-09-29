<?php

namespace CyberPanel\Events\Events\TypedEvents;

use CyberPanel\Events\Event;

class EventWithRemoteAddress extends Event {

	protected string $remoteAddress;

	public function __construct(string $remoteAddress) {
		$this->remoteAddress = $remoteAddress;

	}

	public function getRemoteAddress(): string {
		return $this->remoteAddress;
	}

}


