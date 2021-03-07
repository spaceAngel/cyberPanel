<?php

namespace CyberPanel\System;

use CyberPanel\System\ShellCommands\FileSystem as Commands;
use CyberPanel\Utils\DateTime;
use CyberPanel\Utils\Miscellaneous;

class FileSystem {

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function ls(string $path) {
		$files = Executer::execAndGetResponse(
			sprintf(Commands::CMD_LS, $path)
		);
		$ls = explode("\n", $files);
		$rslt = [];
		foreach ($ls as $file) {
			$file = explode('|', $file);
			$item = [
				'mode' => $file[0],
				'size' => Miscellaneous::bytesToHuman($file[1]),
				'name' => trim($file[3]),
				'mtime' => $file[2],
				'isdir' => FALSE,
			];
			if (substr($file[0], 0, 1) == 'd') {
				$item['size'] = 'DIR';
				$item['isdir'] = TRUE;
			}
			$rslt[] = $item;
		}

		return $rslt;
	}

}
