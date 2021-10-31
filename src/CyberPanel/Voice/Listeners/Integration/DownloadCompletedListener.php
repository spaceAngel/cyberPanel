<?php

namespace CyberPanel\Voice\Listeners\Integration;

use CyberPanel\Events\ListenerInterface;
use CyberPanel\Events\Event;
use CyberPanel\Voice\Speaker;
use CyberPanel\Integration\DownloadManager\Events\DownloadCompletedEvent;

class DownloadCompletedListener implements ListenerInterface{

	public function onEvent(Event $event) : void {
		Speaker::getInstance()->say('Stahování bylo dokončeno.');
	}

	public function listenOn(): string {
		return DownloadCompletedEvent::class;
	}
}
