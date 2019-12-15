<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Keyboard;

class KeyboardCommand extends BaseCommand {
	public function run() : array {
		return $this->getKeyboardLeds();
	}

	private function getKeyboardLeds() : array {
		$leds = explode('|', Executer::execAndGetResponse(Keyboard::CMD_LEDS));
		$rslt = [];
		foreach ($leds as $led) {
			$led = explode(':', $led);
			$rslt[$led[0]] = $led[1];
		}

		return $rslt;
	}
}
