<?php

namespace CyberPanel\Macros;

use CyberPanel\System\Executer;
use CyberPanel\Utils\Traits\HasSocketClient;

class MacroHandlingService {

	use HasSocketClient;

	protected const TICK_INTERVAL = 0.4;

	protected const TICK_CHECK_ENABLE = 3000;

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
		$i = 0;
		while (TRUE) {
			if (file_exists($this->pipefile)) {
				Executer::exec(
					'/bin/bash < ' . $this->pipefile . '; rm ' . $this->pipefile
				);
			}
			if ($i % self::TICK_CHECK_ENABLE == 0) {
				$this->checkMacrosEnabled();
				$i = 0;
			}
			$i++;
			sleep(self::TICK_INTERVAL);
		}
	}

	public function execCommand(string $command) : void {
		$pipe = fopen($this->pipefile, 'w+');
		fwrite($pipe, $command . "\n");
		fclose($pipe);
	}

	protected function checkMacrosEnabled() : void {
		$rslt = [];
		foreach (MacroManager::getInstance()->getMacros() as $key => $macro) {
			if (is_callable($macro->getCheckEnabledFunction())) {
				$rslt[$key] = call_user_func($macro->getCheckEnabledFunction());
			} else {
				$rslt[$key] = TRUE;
			}
		}
		$this->sendToSocketServer([
			'command' => 'storage',
			'parameters' => [
				'key' => 'macros.enabled',
				'value' => $rslt,
			]
		]);
	}


}
