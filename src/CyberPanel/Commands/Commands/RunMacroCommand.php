<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Configuration\Configuration;
use CyberPanel\System\Executer;

class RunMacroCommand extends BaseCommand {
	public function run() : array {
		$macros = Configuration::getInstance()->getMacroList()->getMacros();
		$macro = $macros[$this->parameters[0]];
		if ($macro->getCommand()) {
			Executer::exec($macro->getCommand());
		}
		return[];
	}
}
