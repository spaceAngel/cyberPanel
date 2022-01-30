<?php

namespace CyberPanel\Collector\Collectors;

use CyberPanel\Collector\CollectorInterface;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Keyboard;

class KeyboardCollector implements CollectorInterface {

	public static function getStorageVariableName() : string {
		return 'keyboard';
	}

	public function getTicks() : int {
		return 1;
	}

	public function collect() : array {
		$leds = explode('|', Executer::execAndGetResponse(Keyboard::CMD_LEDS));
		$rslt = [];
		foreach ($leds as $led) {
			$led = explode(':', $led);
			$rslt[$led[0]] = $led[1];
		}
		return $rslt;
	}
}
