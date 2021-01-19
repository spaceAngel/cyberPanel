<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Macros\MacroManager;

class RunMacroCommand extends BaseCommand {
	public function run() : array {
		MacroManager::getInstance()->runMacro(
			$this->parameters[0]
		);
		return[];
	}
}
