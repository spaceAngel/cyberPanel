<?php

namespace CyberPanel\System\ShellCommands;

interface Keyboard {

	// phpcs:disable Generic.Files.LineLength
	const CMD_LEDS = 'xset q | grep Caps | sed -e "s/00://; s/[0-9][0-9]:/|/g; s/ //g;s/\(.*\)/\L\1/"';
	// phpcs:enable

}
