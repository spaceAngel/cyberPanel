<?php

namespace CyberPanel\Voice\Listeners\TerminalConnections;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Voice\Speaker;
use CyberPanel\Events\Events\Terminal\TerminalConnectedEvent;

class TerminalConnectedListener implements ListenerInterface {

	public function onEvent(Event $event) : void {
		if ($event->getRemoteAddress() != '127.0.0.1') {
			Speaker::getInstance()->say(
				sprintf('Terminál %s připojen.', $event->getRemoteAddress()),
				TRUE
			);
		}
	}

	public function listenOn(): string {
		return TerminalConnectedEvent::class;
	}
}
