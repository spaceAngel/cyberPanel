<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Configuration\Configuration;

class LoadMacrosCommand extends BaseCommand {
	public function run() : array {
		$macros = [];
		foreach (Configuration::getInstance()->getMacroList()->getMacros() as $macro) {
			$macros[] = [
				'caption' => $macro->getCaption(),
				'icon' => $macro->getIcon(),
				'hash' => $macro->getHash(),
				'isDelimiter' => $macro->getIsDelimiter(),
			];
		}
		return [ 'macros' => $macros];
	}
}
