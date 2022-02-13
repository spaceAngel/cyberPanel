<?php

namespace CyberPanel\Integration\KdePlasma\Listeners\TerminalConnections;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Events\Events\Terminal\TerminalConnectedEvent;
use CyberPanel\Integration\KdePlasma\Notifier;

class TerminalConnectedListener implements ListenerInterface {

	public function onEvent(Event $event) : void {
		if ($event->getRemoteAddress() != '127.0.0.1') {
			Notifier::notify(
				sprintf('Terminal %s connected.', $event->getRemoteAddress())
			);
		}
	}

	public function listenOn(): string {
		return TerminalConnectedEvent::class;
	}
}
