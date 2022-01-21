<?php

namespace CyberPanel\System;

use CyberPanel\DataStructs\System\GpuSystemInfo;
use CyberPanel\System\ShellCommands\Keyboard;

use CyberPanel\Events\EventManager;
use CyberPanel\Events\Events\Hardware\GpuTemperatureEvent;
use CyberPanel\Events\Events\Hardware\CpuTemperatureEvent;

use CyberPanel\Utils\DateTime;
use CyberPanel\Utils\Miscellaneous;
use CyberPanel\Utils\Traits\HasSocketClient;

class SystemDataCollector {

	public const STORAGEKEY_SYSTEM = 'systen';
	public const STORAGEKEY_KEYBOARD = 'keyboard';
	public const STORAGEKEY_HWINFO = 'hwinfo';
	public const STORAGEKEY_UPSSTATUS = 'upsstatus';

	protected const TICKS_HWINFO = 20;
	protected const TICKS_UPS_STATUS = 2;

	protected static self $instance;

	use HasSocketClient;

	protected function __construct() {
		$this->builSocketClient();
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

	protected function runLoop() : void {
		$tickerHwInfo = 0;
		$tickerUpsStatus = 0;

		while (TRUE) {
			$data = [
				self::STORAGEKEY_SYSTEM => $this->collectSystemMetrics(),
				self::STORAGEKEY_KEYBOARD => $this->collectKeyboardState(),
			];
			if ($tickerHwInfo % self::TICKS_HWINFO == 0) {
				$data[self::STORAGEKEY_HWINFO] = $this->collectHwInfo();
				$tickerHwInfo = 0;
			}

			if ($tickerUpsStatus % self::TICKS_UPS_STATUS == 0) {
				$data[self::STORAGEKEY_UPSSTATUS] = $this->collectUpsStatus();
				$tickerUpsStatus = 0;
			}

			$tickerHwInfo++;
			$tickerUpsStatus++;
			$this->sentToServer($data);
		}
	}

	protected function collectUpsStatus() : array {
		$status = Ups::getInstance()->getUpsStatus();
		if (empty($status)) {
			return [];
		}
		return [
			'charge' => $status->getCharge(),
			'runtime' => [
				'human' =>	DateTime::secondsToHuman($status->getRuntime()),
				'seconds' => $status->getRuntime()
			],
			'power' => $status->getRealpower(),
			'load' => [
				'watts' => $status->getLoadInWatts(),
				'util' => $status->getLoad(),
			],
		];
	}

	protected function collectKeyboardState() : array {
		$leds = explode('|', Executer::execAndGetResponse(Keyboard::CMD_LEDS));
		$rslt = [];
		foreach ($leds as $led) {
			$led = explode(':', $led);
			$rslt[$led[0]] = $led[1];
		}
		return $rslt;
	}

	protected function collectSystemMetrics() : array {
		$gpu = SystemInfo::getInstance()->getGpuInfo();
		$memory = SystemInfo::getInstance()->getMemory();
		$rslt = [
			'temperatures' => [
				'gpu' => $gpu->getTemperature(),
				'cpu' => SystemInfo::getInstance()->getTempCpu(),
			],
			'cpu' => [
				'load' => SystemInfo::getInstance()->getCpuLoad(),
				'frequency' => SystemInfo::getInstance()->getCpuFrequency(),
			],
			'memory' => [
				'used' => $this->formatMemory($memory->getUsed()),
				'total' => $this->formatMemory($memory->getTotal()),
				'load' => $memory->getLoad()
			],
			'fans' => $this->getFans(),
			'processes' => SystemInfo::getInstance()->getProcessList(),
			'locked' => Systeminfo::getInstance()->isLockedScreen(),
			'gpu' => $this->getGpuInfo($gpu),
		];
		$this->fireEvents($rslt);
		return $rslt;
	}

	protected function collectHwInfo() : array {
		$rslt = [
			'storages' => $this->buildStorageStruct(),
			'gpu' => SystemInfo::getInstance()->getGpuName(),
			'cpu' => SystemInfo::getInstance()->getCpuName(),
			'kernel' => SystemInfo::getInstance()->getKernelVersion(),
			'distro' => SystemInfo::getInstance()->getDistro(),
			'uptime' => SystemInfo::getInstance()->getUptime(),
		];
		return $rslt;
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

	protected function getGpuInfo(GpuSystemInfo $gpu) : array {
		return [
				'load' => $gpu->getLoad(),
				'memory' => [
						'free' => $gpu->getMemoryFree(),
						'total' => $gpu->getMemoryTotal(),
				]
		];
	}

	protected function getFans() : array {
		$rslt = [];
		$fans = SystemInfo::getInstance()->getChaseFanSpeed();
		foreach ($fans as $name => $fan) {
			$rslt[$name] = [
					'speed' => $fan->getSpeed(),
					'min' => $fan->getMin(),
					'max' => $fan->getMax(),
					'utilisation' => $fan->getUtilisation()
			];
		}
		return $rslt;
	}

	protected function formatMemory(int $bytes) : array {
		return [
				'bytes' => $bytes,
				'human' => Miscellaneous::bytesToHuman($bytes)
		];
	}

	protected function buildStorageStruct() : array {
		$rslt = [];
		foreach (SystemInfo::getInstance()->getStorages() as $storage) {
			$rslt[] = [
				'caption' => $storage->getName(),
				'size' => $storage->getSize(),
				'used' => $storage->getUsed(),
				'available' => $storage->getAvailable(),
			];
		}
		return $rslt;
	}

	protected function fireEvents(array $struct) : void {
		EventManager::getInstance()->event(
			new CpuTemperatureEvent($struct['temperatures']['cpu'])
		);
		EventManager::getInstance()->event(
			new GpuTemperatureEvent($struct['temperatures']['gpu'])
		);
	}
}
