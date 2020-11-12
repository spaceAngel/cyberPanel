<?php

use \CyberPanel\Configuration\Configuration;

return '
var config = {
	lastfmApiKey: "' . Configuration::getInstance()->getLastFmApiKey() . '",
	panes: [
		"macros",
		"processes",
		"sysinfo",
		"loadgraphs",
		"ping",
		"numkeyboard",
		"downloads",
		"music",
		"covid",
		"hospitals"
	],
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
