<?php

namespace CyberPanel\System\ShellCommands;

interface Media {

	// phpcs:disable Generic.Files.LineLength
	const CMD_VOLUME = "pactl list sinks | grep '^[[:space:]]Volume:' | head -n 1 |sed -e 's,.* \\([0-9][0-9]*\\)%.*,\\1,'";
	// phpcs:enable

}
