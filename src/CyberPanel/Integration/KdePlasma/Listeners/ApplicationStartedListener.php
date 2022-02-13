<?php

namespace CyberPanel\Integration\KdePlasma\Listeners;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Events\Events\Runtime\ApplicationStartedEvent;

use CyberPanel\Integration\KdePlasma\Notifier;

class ApplicationStartedListener implements ListenerInterface{

	public function onEvent(Event $event) : void {
		Notifier::notify('Application cyberPanel started');
	}

	public function listenOn(): string {
		return ApplicationStartedEvent::class;
	}
}
