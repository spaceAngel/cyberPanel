<?php

namespace CyberPanel\Voice;

use CyberPanel\System\Executer;

class Speaker {


	protected static self $instance;

	protected $pipe;

	protected $pipefile;

	protected int $gain = 30;

	protected string $voice = 'cs+f2';

	protected bool $enabled = TRUE;

	private function __construct() {
	}

	protected function createPipeIfNotExists() : void {
		$isPipeRunning = FALSE;
		if (!empty($this->pipefile)) {
			$isPipeRunning = Executer::execAndGetResponse(
				CommandBuilder::isPipeRunning($this->pipefile)
			);

		}
		if (!$isPipeRunning) {
			if (!empty($this->pipefile)) {
				unlink($this->pipefile);
			}
			$this->createPipe();
		}
	}

	protected function createPipe() : void {
		$this->pipefile = '/tmp/pipe_' . uniqid();
		$this->pipe = fopen($this->pipefile, 'w');
		fwrite($this->pipe, 'sleep 1;');
		Executer::exec('/bin/sh < ' . $this->pipefile);
	}


	public function setVoice(string $voice) : void {
		$this->voice = $voice;
	}

	public function setGain(int $gain) : void {
		$this->gain = $gain;
	}

	public function setEnabled(bool $enabled) : void {
		$this->enabled = $enabled;
	}

	public function getEnabled() : bool {
		return $this->enabled;
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function say(string $message, bool $always = FALSE) : void {
		if (!$this->enabled) {
			return;
		}
		$this->createPipeIfNotExists();
		fwrite(
			$this->pipe,
			CommandBuilder::build(
				$message,
				!$always,
				$this->voice,
				$this->gain
			)
		);
	}

}
