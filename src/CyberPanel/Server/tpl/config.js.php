<?php

use \CyberPanel\Configuration\Configuration;

$sidebar = [];
foreach (Configuration::getInstance()->getSidebarWidgets() as $widget) {
	$sidebar[] = sprintf('"%s"', $widget);
}

return '
var config = {
	lastfmApiKey: "' . Configuration::getInstance()->getLastFmApiKey() . '",
	panes: [
		"macros",
		"processes",
		"sysinfo",
		"network",
		"numkeyboard",
		"downloads",
		"music",
		"covid",
		"hospitals",
		"files"
	],
	sidebar: [' . implode(',', $sidebar). '],
	hwLimits: {
		cpu: {
			temperature: ' . Configuration::getInstance()->getSystemLimits()->getTempCpu() . '
		},
		gpu: {
			temperature: ' . Configuration::getInstance()->getSystemLimits()->getTempGpu() . '
		}
	}
};
';
