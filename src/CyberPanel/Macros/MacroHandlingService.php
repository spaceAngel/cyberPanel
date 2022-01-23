<?php

namespace CyberPanel\Macros;

use CyberPanel\System\Executer;

class MacroHandlingService {

	protected string $pipefile;

	protected static self $instance;

	protected function __construct() {
		$this->pipefile = '/tmp/pipeexec_' . uniqid();
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function runExecuter() : void {
		if (0 !== pcntl_fork()) {
		} else {
			$this->runLoop();
		}
	}

	protected function runLoop() : void {
		while (TRUE) {
			if (file_exists($this->pipefile)) {
				Executer::exec(
					'/bin/bash < ' . $this->pipefile . '; rm ' . $this->pipefile
				);
			}
			sleep(1);
		}
	}

	public function execCommand(string $command) : void {
		$pipe = fopen($this->pipefile, 'w+');
		fwrite($pipe, $command . "\n");
		fclose($pipe);
	}


}
