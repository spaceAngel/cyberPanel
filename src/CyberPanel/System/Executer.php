<?php

namespace CyberPanel\System;

class Executer {
	public static function exec(string $cmd) {
		$pid = pcntl_fork ();
		switch ($pid) {
			// fork errror
			case - 1 :
				return FALSE;

			case 0 :
				popen( "nohup $($cmd) 2>&1  &", 'r' );
				exit();

			// return the child pid in father
			default :
				pcntl_wait($status);
				return $pid;
		}
	}

	public static function execAndGetResponse(string $cmd) : string {
		return (string)trim(shell_exec($cmd));
	}
}
