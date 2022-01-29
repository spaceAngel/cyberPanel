<?php

return [
	'internet.browsers.chromium' => [
		'command' => 'chromium-browser',
	],
	'internet.browsers.konqueror' => [
		'command' => 'konqueror',
	],
	'internet.browsers.firefox.profileManager' => [
		'command' => 'firefox -p',
	],
	'internet.browsers.vivaldi' => [
		'command' => 'vivaldi',
	],

	'internet.email.breeze.claws' => [
		'icon' => '/usr/share/icons/breeze/apps/48/claws-mail.svg',
		'notification' => "mail && mail.unread > 0? mail.unread : '';",
	],

	'internet.irc.hexchat' => [
		'command' => 'hexchat',
	],

	'internet.rss.akregator' => [
		'command' => 'akregator',
	],


];
