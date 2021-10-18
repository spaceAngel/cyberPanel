<?php

namespace CyberPanel\Events\Events\Hardware;

use CyberPanel\Events\Event;
use CyberPanel\DataStructs\System\Storage;

class StorageCapacityEvent extends Event {

	protected Storage $value;

	public function __construct(Storage $value) {
		$this->value = $value;

	}

	public function getStorage() : Storage {
		return $this->value;
	}

}
