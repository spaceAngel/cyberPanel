<?php

namespace CyberPanel\Voice\Listeners\Hardware;

use CyberPanel\Events\Events\Hardware\GpuTemperatureEvent;
use CyberPanel\Configuration\Configuration;
use CyberPanel\Voice\Listeners\GenericValueChangeInTimeListener;

class GpuTemperatureWarnListener extends GenericValueChangeInTimeListener {

	public function listenOn() : string {
		return GpuTemperatureEvent::class;
	}

	protected function getLimitValue(): int {
		return Configuration::getInstance()
		->getSystemLimits()
		->getGpu()
		->getTemperature();
	}

	protected function getMessageValueIsIncreased() : string {
		return 'Varování: teplota grafického čipu dosáhla % stupňů';
	}

	protected function getMessageValueIsStillOverlimit() : string {
		return 'Varování: teplota grafického čipu je stále na hodnotě % stupňů';
	}

	protected function getMessageValueBackToNormal() : string {
		return 'Teplota grafického čipu se vrátila na normální hodnotu';
	}

}
