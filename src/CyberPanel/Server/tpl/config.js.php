<?php

use \CyberPanel\Configuration\Configuration;

$sidebar = [];
foreach (Configuration::getInstance()->getSidebarWidgets() as $widget) {
	$sidebar[] = sprintf('"%s"', $widget);
}

$mainpanel = [];
foreach (Configuration::getInstance()->getMainPanels() as $panel) {
	$mainpanel[] = sprintf('"%s"', $panel);
}

$publicTransportDepartures = 'names[]=' . implode(
	'&names[]=',
	Configuration::getInstance()->getSubSection('departures')->getDepartures()
);

return '
var config = {
	lastfmApiKey: "' . Configuration::getInstance()->getApiKey('lastfm') . '",
	keys: {
		golemio: "' . Configuration::getInstance()->getApiKey('golemio') . '"
	},
	panes: [' . implode(',', $mainpanel). '],
	sidebar: [' . implode(',', $sidebar). '],
	hwLimits: {
		cpu: {
			temperature: ' . Configuration::getInstance()->getSystemLimits()->getCpu()->getTemperature() . ',
			load: ' . Configuration::getInstance()->getSystemLimits()->getCpu()->getLoad() . '
		},
		gpu: {
			temperature: ' . Configuration::getInstance()->getSystemLimits()->getGpu()->getTemperature() . ',
			load: ' . Configuration::getInstance()->getSystemLimits()->getGpu()->getLoad() . '
		},
		memory: ' . Configuration::getInstance()->getSystemLimits()->getMemory() . ',
		storage: ' . Configuration::getInstance()->getSystemLimits()->getStorage() . '
	},
	publicTransportDepartures: "' . $publicTransportDepartures .'"
};
';
