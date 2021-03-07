<?php

namespace CyberPanel\System\ShellCommands;

interface FileSystem {

	// phpcs:disable Generic.Files.LineLength
	const CMD_LS = 'ls %s -laFv --group-directories-first  --time-style=long-iso |tail +4 |awk \'{printf $1"|"$5"|"$6" "$7"|";for (i=8; i<19; i++) printf " "$i;print ""}\'';
	// phpcs:enable
}
