<?php

namespace CyberPanel\System\ShellCommands;

interface KdeSettings {

	// phpcs:disable Generic.Files.LineLength
	const CMD_LOCKSCREENIMAGE = 'cat $HOME/.config/kscreenlockerrc |grep Image |sed -e "s/Image=file\:\/\///g"';
	// phpcs:enable
}

