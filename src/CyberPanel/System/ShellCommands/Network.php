<?php

namespace CyberPanel\System\ShellCommands;

interface Network {

	//phpcs:disable Generic.Files.LineLength
	const CMD_IP_LOCAL = "ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'";

	const CMD_IP_PUBLIC = 'curl -4 ipinfo.io/ip --silent';

	const CMD_IP_GATEWAY = "route -n | grep 'UG[ \t]' | awk '{print $2}'";

	const CMD_IP_DNS = 'systemd-resolve --status |grep "Current DNS" | grep -Eo "([0-9]*\.){3}[0-9]*"';

	const CMD_MAC = 'ifconfig |grep ether |grep -Eo "([0-9a-z]*\:){5}[0-9a-z]*"';
	// phpcs:enable

}
