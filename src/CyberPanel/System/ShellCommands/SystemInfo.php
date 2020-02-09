<?php

namespace CyberPanel\System\ShellCommands;

interface SystemInfo {

	// phpcs:disable Generic.Files.LineLength
	const CMD_TEMP_CPU = "sensors|sed -E -n '/[0-9]:.*\+[0-9]+\.[0-9]°[CF]/!b;s:\.[0-9]*°[CF].*$::;s:^.*\+::;p'";

	const CMD_TEMP_GPU = 'nvidia-smi --query-gpu=temperature.gpu --format=csv,noheader';

	const CMD_STORAGES = 'df --output=fstype,target,size,avail,used';

	const CMD_CPU_LOAD = "awk -v a=\"$(awk '/cpu /{print $2+$4,$2+$4+$5}' /proc/stat; sleep 0.2)\" '/cpu /{split(a,b,\" \"); print 100*($2+$4-b[1])/($2+$4+$5-b[2])}'  /proc/stat";

	const CMD_MEMORY = "free | awk '/Mem:/ { print sprintf(\"%u %u\",$2, $3+$5) }' ";

	const CMD_PROCESSLIST = 'ps -e -o "%c|%C|%z|" -o user:20 -o "|%a" --sort -pcpu,-rss ';

	// phpcs:enable

}
