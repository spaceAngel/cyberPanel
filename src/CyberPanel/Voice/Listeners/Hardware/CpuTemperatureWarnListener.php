<?php

namespace CyberPanel\Voice\Listeners\Hardware;

use CyberPanel\Events\Events\Hardware\CpuTemperatureEvent;
use CyberPanel\Configuration\Configuration;
use CyberPanel\Voice\Listeners\GenericValueChangeInTimeListener;

class CpuTemperatureWarnListener extends GenericValueChangeInTimeListener {

	public function listenOn() : string {
		return CpuTemperatureEvent::class;
	}

	protected function getLimitValue(): int {
		return Configuration::getInstance()
		->getSystemLimits()
		->getCpu()
		->getTemperature();
	}

	protected function getMessageValueIsIncreased() : string {
		return 'Varování: teplota jádra dosáhla % stupňů';
	}

	protected function getMessageValueIsStillOverlimit() : string {
		return 'Varování: teplota jádra je stále na hodnotě % stupňů';
	}

	protected function getMessageValueBackToNormal() : string {
		return 'Teplota jádra se vrátila na normální hodnotu';
	}

}
