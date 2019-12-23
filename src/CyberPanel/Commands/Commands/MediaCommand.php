<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Media;

class MediaCommand extends BaseCommand {
	public function run() : array {
		switch ($this->parameters[0]) {

		}

		return [
			'volume' => (int)Executer::execAndGetResponse(Media::CMD_VOLUME),
		];
	}
}
