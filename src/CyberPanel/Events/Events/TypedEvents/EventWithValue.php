<?php

namespace CyberPanel\Events\Events\TypedEvents;

use CyberPanel\Events\Event;

class EventWithValue extends Event {

	protected float $value;

	public function __construct(float $value) {
		$this->value = $value;

	}

	public function getValue(): float {
		return $this->value;
	}

}


