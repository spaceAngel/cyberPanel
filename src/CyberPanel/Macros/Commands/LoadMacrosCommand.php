<?php

namespace CyberPanel\Macros\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Macros\MacroManager;

class LoadMacrosCommand extends BaseCommand {
	public function run() : array {
		$macros = [];
		foreach (MacroManager::getInstance()->getMacros() as $macro) {
			$macros[] = [
				'caption' => $macro->getCaption(),
				'icon' => $macro->getIcon(),
				'iconImage' => $macro->getIconImage(),
				'hash' => $macro->getHash(),
				'isDelimiter' => $macro->getIsDelimiter(),
				'position' => $macro->getPosition(),
				'notification' => $macro->getNotification(),
			];
		}
		return [ 'macros' => $macros];
	}
}
