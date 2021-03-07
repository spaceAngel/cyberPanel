<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\FileSystem;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Applications;

class FileManagerCommand extends BaseCommand {

	public function run() : array {
		if (!empty($this->parameters) && !empty($this->parameters[0])) {
			if (is_dir($this->parameters[0])) {
				$path = $this->parameters[0];
			} else {
				$path = dirname($this->parameters[0]);
			}
			$path = realpath($path);
		} else {
			$path = $_SERVER['HOME'];
		}

		return [
			'path'  => $path,
			'files' => FileSystem::getInstance()->ls($path),
		];
	}
}
