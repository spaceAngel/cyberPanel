<?php

namespace CyberPanel\System\ShellCommands;

interface KeyboardEmulator{

	// phpcs:disable Generic.Files.LineLength
	const CMD_KEYPRESS = 'xdotool key %s';
	// phpcs:enable

}
