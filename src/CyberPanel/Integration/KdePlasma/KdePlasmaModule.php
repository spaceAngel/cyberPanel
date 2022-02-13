<?php

namespace CyberPanel\Integration\KdePlasma;


//phpcs:disable Generic.Files.LineLength

use CyberPanel\Events\EventManager;
use CyberPanel\Integration\KdePlasma\Listeners\TerminalConnections\TerminalConnectedListener;
use CyberPanel\Integration\KdePlasma\Listeners\TerminalConnections\TerminalDisconnectedListener;
use CyberPanel\Integration\KdePlasma\Listeners\TerminalConnections\TerminalUnauthorizedListener;
use CyberPanel\Integration\KdePlasma\Listeners\ApplicationStartedListener;
//phpcs:enable

class KdePlasmaModule {

	private function __construct() {
	}

	public static function init() : void {
		EventManager::getInstance()->registerListeners([
			ApplicationStartedListener::class,

			TerminalConnectedListener::class,
			TerminalDisconnectedListener::class,
			TerminalUnauthorizedListener::class,
		]);
	}


}
