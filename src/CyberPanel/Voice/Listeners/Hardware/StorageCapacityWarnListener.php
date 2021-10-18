<?php

namespace CyberPanel\Voice\Listeners\Hardware;

use CyberPanel\Configuration\Configuration;
use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Events\Hardware\StorageCapacityEvent;
use CyberPanel\Events\Event;
use CyberPanel\Voice\Speaker;

class StorageCapacityWarnListener implements ListenerInterface {

	protected const WARN_EVERY_SECONDS = 60 * 3;
	protected $lastWarn = [];

	public function listenOn() : string {
		return StorageCapacityEvent::class;
	}

	public function onEvent(Event $event) : void {
		$storage = $event->getStorage();
		if (
			(
				!array_key_exists($storage->getName(), $this->lastWarn)
				|| $this->lastWarn[$storage->getName()] + self::WARN_EVERY_SECONDS < time()
			)
			&& $storage->getAvailablePercent() < $this->getLimit()

		) {
			$this->lastWarn[$storage->getName()] = time() - 1;
			Speaker::getInstance()->say(
				sprintf(
					'Varování. Na disku %s zbývá volných pouze %s procent.',
					$this->getName($storage->getName()),
					$storage->getAvailablePercent()
				),
				TRUE
			);
		}
	}

	protected function getLimit() : int {
		return Configuration::getInstance()->getSystemLimits()->getStorage();
	}

	protected function getName(string $name) : string {
		return basename($name);
	}

}
