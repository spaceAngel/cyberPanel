<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Applications;

class OpenInBrowserCommand extends BaseCommand{


	public function run() : array {
		Executer::exec(
			sprintf(
				Applications::CMD_OPEN_IN_BROWSER,
				$this->parameters[0]
			)
		);
		return [];
	}

}
