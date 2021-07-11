<?php

namespace CyberPanel\System\ShellCommands;

interface Ups {

	const CMD_STATUS = "upsc %s 2>&1 | grep -v '^Init SSL'";

}
