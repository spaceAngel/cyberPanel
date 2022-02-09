<?php

namespace CyberPanel\Integration\Clipboard\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Integration\Clipboard\Clipboard;

class SetClipboardContentCommand extends BaseCommand {

	public function run() : array {
		Clipboard::setContent(
			$this->parameters[0]
		);
		return [];
	}


}
