<?php

namespace CyberPanel\System;

class Executer {
	public static function exec(string $cmd) {
		$pid = pcntl_fork ();
		switch ($pid) {
			// fork errror
			case - 1 :
				return false;

			case 0 :
				popen( "nohup $cmd &", 'r' );
				exit();
				break;

			// return the child pid in father
			default :
				pcntl_wait($status) ;
				return $pid;
		}
	}
}