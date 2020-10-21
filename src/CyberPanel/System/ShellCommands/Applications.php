<?php

namespace CyberPanel\System\ShellCommands;

interface Applications {

	const CMD_OPEN_IN_BROWSER = 'xdg-open %s';
	const CMD_DOWNLOAD_FILE = 'wget -bq -O %s %s';

}
