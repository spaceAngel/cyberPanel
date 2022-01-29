<?php
use CyberPanel\System\Executer;

return [
	'multimedia.audacious' => [
		'command' => 'audacious',
	],

	'multimedia.audacious.shortcuts.search' => [
		'icon' => '/usr/share/icons/breeze/apps/48/mixxx.svg',
		'command' => 'xdotool search --class audacious key --window %@ j',
		'checkEnabledFunction' => function() {
			return Executer::execAndGetResponse(
				'ps -afx |grep audacious | grep -v grep | wc -l'
			) == '1';

		}


	]

];
