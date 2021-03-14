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

return '
var config = {
	lastfmApiKey: "' . Configuration::getInstance()->getLastFmApiKey() . '",
	panes: [' . implode(',', $mainpanel). '],
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
