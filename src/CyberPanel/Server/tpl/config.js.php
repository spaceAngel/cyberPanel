<?php

return '
var config = {
	lastfmApiKey: "' . \CyberPanel\Configuration\Configuration::getInstance()->getLastFmApiKey() . '",
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
	]
};
';
