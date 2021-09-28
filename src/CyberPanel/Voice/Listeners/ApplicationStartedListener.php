<?php

namespace CyberPanel\Voice\Listeners;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Events\Events\Runtime\ApplicationStartedEvent;
use CyberPanel\Voice\Speaker;

class ApplicationStartedListener implements ListenerInterface{

	public function onEvent(Event $event) : void {
		Speaker::getInstance()->say('Aplikace CajbrPanel nastartována.');
	}

	public function listenOn(): string {
		return ApplicationStartedEvent::class;
	}
}
