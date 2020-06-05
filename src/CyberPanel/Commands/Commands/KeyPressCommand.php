<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\KeyboardEmulator;

class KeyPressCommand extends BaseCommand {

	public function run(): array {
		KeyboardEmulator::getInstance()->keyPress(
			$this->parameters[0]
		);
		return [ ];
	}
}
