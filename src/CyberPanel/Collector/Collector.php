<?php

namespace CyberPanel\Collector;

use CyberPanel\Utils\Traits\HasSocketClient;

use CyberPanel\Collector\Collectors\UpsCollector;
use CyberPanel\Collector\Collectors\KeyboardCollector;
use CyberPanel\Collector\Collectors\SystemStateCollector;
use CyberPanel\Collector\Collectors\HwCollector;
use CyberPanel\Collector\Collectors\NetworkCollector;

class Collector {

	protected static self $instance;

	protected array $collectors = [];

	use HasSocketClient;

	protected function __construct() {
		$this->registerCollector(UpsCollector::class);
		$this->registerCollector(KeyboardCollector::class);
		$this->registerCollector(SystemStateCollector::class);
		$this->registerCollector(HwCollector::class);
		$this->registerCollector(NetworkCollector::class);
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function runCollector() : void {
		if (0 !== pcntl_fork()) {
		} else {
			$this->runLoop();
		}
	}

	public function registerCollector(string $collectorClass) : void {
		if (class_exists($collectorClass)) {
			$this->addCollector(new $collectorClass);
		}
	}

	protected function addCollector(CollectorInterface $collector) {
		$this->collectors[$collector::getStorageVariableName()] = $collector;
	}

	protected function runLoop() : void {
		$ticks = 0;

		while (TRUE) {
			$data = [];
			foreach ($this->collectors as $collector) {
				if ($ticks % $collector->getTicks() == 0) {
					$data[$collector::getStorageVariableName()] = $collector->collect();
				}
			}
			$this->sentToServer($data);
			$ticks++;
		}
	}

	protected function sentToServer($data) {
		$request = [];
		foreach ($data as $key => $struct) {
			$request[] = [
				'command' => 'storage',
				'parameters' => [
					'key' => $key,
					'value' => $struct,
				]
			];
		}
		$this->sendToSocketServer($request);
	}

}
