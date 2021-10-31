<?php

namespace CyberPanel;

class Environment {

	const DEFAULT_PORT = 8081;

	protected int $port = self::DEFAULT_PORT;

	protected bool $runningWithVersionSwitch = FALSE;

	protected bool $runningWithHelpSwitch = FALSE;

	protected bool $runningWithVerboseSwitch = FALSE;

	protected bool $runninsWithDeamonizeSwitch = FALSE;

	private static self $instance;

	private function __construct() {
	}

	public static function getInstance() {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function loadEnvironmentVariables() : void {
		$options = getopt(
			'p::d::v::h::V::',
			['port::', 'daemonise', 'version', 'help', 'verbose']
		);

		$this->setPort($options);
		$this->setRunningWithVersionSwitch($options);
		$this->setRunningWithVerboseSwitch($options);
		$this->setRunningWithHelpSwitch($options);
		$this->setRunningWithDeamonizeSwitch($options);
	}

	public function getPort() : int {
		return $this->port;
	}

	public function getRunningWithDeamonizeSwitch() : bool {
		return $this->runninsWithDeamonizeSwitch;
	}

	public function getRunningWithVersionSwitch() : bool {
		return $this->runningWithVersionSwitch;
	}

	public function getRunningWithHelpSwitch() : bool {
		return $this->runningWithHelpSwitch;
	}

	public function getRunningWithVerboseSwitch() : bool {
		return $this->runningWithVerboseSwitch;
	}

	private function setRunningWithVersionSwitch(array $options) : void {
		$this->runningWithVersionSwitch = $this->isRunningWithSwitch(
			'V',
			'version',
			$options
		);
	}

	private function setRunningWithHelpSwitch(array $options) : void {
		$this->runningWithHelpSwitch = $this->isRunningWithSwitch(
			'h',
			'help',
			$options
		);
	}

	private function setRunningWithDeamonizeSwitch(array $options) : void {
		$this->runninsWithDeamonizeSwitch = $this->isRunningWithSwitch(
			'd',
			'daemonized',
			$options
		);
	}

	private function setRunningWithVerboseSwitch(array $options) : void {
		$this->runningWithVerboseSwitch = $this->isRunningWithSwitch(
			'v',
			'verbose',
			$options
		);
	}

	private function setPort(array $options) : void {
		if (array_key_exists('p', $options)) {
			$this->port = (int)$options['p'];
		} elseif (array_key_exists('port', $options)) {
			$this->port = (int)$options['port'];
		}
	}

	private function isRunningWithSwitch(
		string $short,
		string $long,
		array $options
	) : bool {
		return array_key_exists($short, $options)
		|| array_key_exists($long, $options);
	}
}
