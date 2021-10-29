<?php
namespace CyberPanel\Integration\Mail\Client;

use CyberPanel\Utils\Miscellaneous;
use Carbon\Carbon;

class Decorator {

	public static function from(string $sender) : string {
		$sender = strip_tags($sender);
		$sender = trim($sender);
		if (substr($sender, 0, 1) == '"') {
			$sender = substr($sender, 1);
		}

		if (substr($sender, -1) == '"') {
			$sender = substr($sender, 0, -1);
		}
		return $sender;
	}

	public static function size(int $size) : string {
		return Miscellaneous::bytesToHuman($size);
	}

	public static function date(int $timestamp) : string {
		$date = date('y-m-d', $timestamp);
		if ($date == date('y-m-d')) {
			$date = date('H:i', $timestamp);
		}
		return $date;
	}
}
