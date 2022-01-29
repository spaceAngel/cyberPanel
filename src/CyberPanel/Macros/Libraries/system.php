<?php

use CyberPanel\Macros\MacroIconLoader;

MacroIconLoader::registerCommandIconMappings([
	'ksysguard' => 'ksysguard_utilities-system-monitor',
	'kcalc' => 'kcalc_accessories-calculator',
	'krusader' => 'krusader_user',
	'konsole' => 'konsole_utilities-terminal',
]);

return [
	'system.kate' => [
		'command' => 'kate',
	],
	'system.kcalc' => [
		'command' => 'kcalc',
	],
	'system.krusader' => [
		'command' => 'krusader',
	],
	'system.ksysguard' => [
		'command' => 'ksysguard',
	],
	'system.terminal' => [
		'command' => 'konsole',
	],

];
