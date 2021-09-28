<?php

namespace CyberPanel\Voice\Listeners;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Events\Events\Terminal\TerminalDisconnectedEvent;
use CyberPanel\Voice\Speaker;

class TerminalDisconnectedListener implements ListenerInterface{

	public function onEvent(Event $event) : void {
		if ($event->getRemoteAddress() != '127.0.0.1') {
			Speaker::getInstance()->say(
				sprintf('Terminál %s odpojen.', $event->getRemoteAddress()),
				TRUE
			);
		}
	}

	public function listenOn(): string {
		return TerminalDisconnectedEvent::class;
	}
}
