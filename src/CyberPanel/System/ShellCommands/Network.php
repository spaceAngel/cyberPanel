<?php

namespace CyberPanel\System\ShellCommands;

interface Network {

	//phpcs:disable Generic.Files.LineLength
	const CMD_IP_LOCAL = "ip route get 1.1.1.1 | grep -oP 'src \K\S+'";

	const CMD_IP_PUBLIC = 'curl -4 ipinfo.io/ip --silent';

	const CMD_IP_GATEWAY = "route -n | grep 'UG[ \t]' | awk '{print $2}'";

	const CMD_IP_DNS = 'systemd-resolve --status |grep "Current DNS" | grep -Eo "([0-9]*\.){3}[0-9]*"';

	const CMD_MAC = "cat /sys/class/net/$(ip route show default | awk '/default/ {print $5}')/address";
	// phpcs:enable

}
