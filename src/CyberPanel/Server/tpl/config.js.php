<?php

use \CyberPanel\Configuration\Configuration;

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
		"hospitals"
	],
	sidebar: [
		"time",
		"temperatures",
		"cpu",
		"memory",
		"keyboard",
		"date"
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
