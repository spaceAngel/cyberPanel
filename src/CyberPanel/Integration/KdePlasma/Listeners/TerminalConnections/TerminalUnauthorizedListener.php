<?php

namespace CyberPanel\Integration\KdePlasma\Listeners\TerminalConnections;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Events\Events\Terminal\UnauthorizedConnectionEvent;
use CyberPanel\Integration\KdePlasma\Notifier;

class TerminalUnauthorizedListener implements ListenerInterface{

	public function onEvent(Event $event) : void {
		if ($event->getRemoteAddress() != '127.0.0.1') {
			Notifier::notify(
				sprintf('unauthorized terminal %s.', $event->getRemoteAddress()),
				TRUE
			);
		}
	}

	public function listenOn(): string {
		return UnauthorizedConnectionEvent::class;
	}
}
