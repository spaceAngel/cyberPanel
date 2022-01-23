<?php

namespace CyberPanel\Macros\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Storage;

class MacrosEnabledListCommand extends BaseCommand {
	public function run() : array {
		return ['enabled' => Storage::getInstance()->get('macros.enabled')];
	}
}
