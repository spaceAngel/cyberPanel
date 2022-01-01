<?php

namespace CyberPanel\Integration\IcuMonitor\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Utils\Miscellaneous;
use CyberPanel\Integration\DownloadManager\DownloadManager;
use CyberPanel\Integration\IcuMonitor\ValueStorage;

class StoreValuesCommand extends BaseCommand {


	public function run() : array {
		if (count($this->parameters) > 1) {
			ValueStorage::getInstance()->setSpo2Pulse($this->parameters['SPO2_pulse']);
			ValueStorage::getInstance()->setSpo2($this->parameters['SPO2']);

			ValueStorage::getInstance()->setNbpSys($this->parameters['NBP_sys']);
			ValueStorage::getInstance()->setNbpDias($this->parameters['NBP_dias']);
			ValueStorage::getInstance()->setNbpMean($this->parameters['NBP_mean']);
			ValueStorage::getInstance()->setNbpInflating($this->parameters['NBP_inflating']);
			ValueStorage::getInstance()->setNbpTimestamp($this->parameters['NBP_time']);
			ValueStorage::getInstance()->setEcgPulse($this->parameters['ECG_pulse']);
			ValueStorage::getInstance()->setRespiratoryRate($this->parameters['respiratory_rate']);

		} else {
			ValueStorage::getInstance()->reset();
		}
		ValueStorage::getInstance()->setRefreshRate($this->parameters['refreshRate']);
		return [];
	}
}
