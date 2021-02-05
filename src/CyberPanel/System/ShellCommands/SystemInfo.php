<?php

namespace CyberPanel\System\ShellCommands;

interface SystemInfo {

	// phpcs:disable Generic.Files.LineLength
	const CMD_TEMP_CPU = "sensors|sed -E -n '/[0-9]:.*\+[0-9]+\.[0-9]°[CF]/!b;s:\.[0-9]*°[CF].*$::;s:^.*\+::;p'";

	const CMD_STORAGES = 'df --output=fstype,target,size,avail,used | tail -n+2 | sort -k 2';

	const CMD_CPU_LOAD = "awk -v a=\"$(awk '/cpu /{print $2+$4,$2+$4+$5}' /proc/stat; sleep 0.2)\" '/cpu /{split(a,b,\" \"); print 100*($2+$4-b[1])/($2+$4+$5-b[2])}'  /proc/stat";

	const CMD_MEMORY = "free | awk '/Mem:/ { print sprintf(\"%u %u\",$2, $3+$5) }' ";

	const CMD_PROCESSLIST = 'top -bn1 -c -o %MEM -w 180 |tail -n +7 | awk  \'{print $2"|"$6"|"$7"|"$9"|"$12" "$13" "$14" "$15}\' ';

	const CMD_ISLOCKEDSCREEN = 'ps -e | grep kscreenlocker | wc -l';

	const CMD_CPUNAME = 'lshw -short 2> /dev/null |grep -e processor|sed -E "s/[0-9\/ ]* processor[ ]*/ /g"';

	const CMD_GPUNAME = 'lshw -short 2> /dev/null |grep -e display|sed -E "s/[0-9\/\. ]* display[ ]*/ /g"';

	const CMD_KERNELVERSION = 'uname -r';

	const CMD_DISTRO = 'lsb_release -a 2> /dev/null|grep Description |sed -E "s/Description:[ \t]*/ /g"';

	const CMD_UPTIME = 'uptime -p';
	// phpcs:enable

}
