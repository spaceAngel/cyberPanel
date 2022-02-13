<?php

namespace CyberPanel\Integration\KdePlasma;

use CyberPanel\System\Executer;

class Notifier {

	protected const CMD_INFO = 'notify-send -a "cyberPanel"  -i %s "%s"';
	protected const CMD_ERROR = 'notify-send -a "cyberPanel" -u critical -i %s "%s"';

	public static function notify(string $msg, bool $isError = FALSE) : void {
		Executer::exec(
			sprintf(
				$isError ? self::CMD_ERROR : self::CMD_INFO,
				__DIR__ . '/../../../../build/images/icon.png',
				$msg
			)
		);
	}
}
