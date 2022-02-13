<?php

namespace CyberPanel\Integration\KdePlasma\Listeners\TerminalConnections;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Events\Events\Terminal\TerminalDisconnectedEvent;

use CyberPanel\Integration\KdePlasma\Notifier;

class TerminalDisconnectedListener implements ListenerInterface{

	public function onEvent(Event $event) : void {
		if ($event->getRemoteAddress() != '127.0.0.1') {
			Notifier::notify(
				sprintf('Termina %s disconnected.', $event->getRemoteAddress())
			);
		}
	}

	public function listenOn(): string {
		return TerminalDisconnectedEvent::class;
	}
}
