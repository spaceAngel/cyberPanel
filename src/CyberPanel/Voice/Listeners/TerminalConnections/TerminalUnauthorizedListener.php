<?php

namespace CyberPanel\Voice\Listeners\TerminalConnections;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Events\Events\Terminal\TerminalDisconnectedEvent;
use CyberPanel\Voice\Speaker;
use CyberPanel\Events\Events\Terminal\UnauthorizedConnectionEvent;

class TerminalUnauthorizedListener implements ListenerInterface{

	public function onEvent(Event $event) : void {
		if ($event->getRemoteAddress() != '127.0.0.1') {
			Speaker::getInstance()->say(
				sprintf('Varování! Neautorizovaný terminál %s.', $event->getRemoteAddress()),
				TRUE
			);
		}
	}

	public function listenOn(): string {
		return UnauthorizedConnectionEvent::class;
	}
}
