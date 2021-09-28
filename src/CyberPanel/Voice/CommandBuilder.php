<?php

namespace CyberPanel\Voice;

class CommandBuilder {

	protected const COMMAND_QUEUED = '
		tmstmp=$(($(date +%%s) < %s ));
		if [ $tmstmp -eq 1 ]; then
			__VOICECOMMAND__
		fi;
	';

	protected const COMMAND = '
		echo \'%s\' \
		| espeak --stdout -s130 -k15 -a200 -v %s \
		| play -t wav - chorus 0.4 0.8 20 0.5 0.10 2 -t \
			echo 0.9 0.8 33 0.9 \
			echo 0.7 0.7 10 0.2 \
			echo 0.9 0.2 55 0.5 gain %s 2>&1
	';

	protected const COMMAND_IS_PIPE_OPENEND = '
		ps -ef |grep -v grep | grep %s | wc -l
	';

	public static function build(
		string $message,
		bool $timeLimitation,
		string $voice,
		int $gain
	) : string {
		$command = sprintf(
			self::COMMAND,
			$message,
			$voice,
			$gain
		);
		if ($timeLimitation) {
			$command = str_replace(
				'__VOICECOMMAND__',
				$command,
				sprintf(self::COMMAND_QUEUED, time() + 2)
			);
		}
		return $command;
	}

	public static function isPipeRunning(string $pipename) : string {
		return sprintf(self::COMMAND_IS_PIPE_OPENEND, $pipename);
	}

}
