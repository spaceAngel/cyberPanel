<?php

namespace CyberPanel\Utils;

class Miscellaneous {

	public static function bytesToHuman($bytes, $precision = 1) : string {
		$units = ['B', 'KB', 'MB', 'GB', 'TB'];

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		// Uncomment one of the following alternatives
		$bytes /= pow(1024, $pow);
		// $bytes /= (1 << (10 * $pow));

		return sprintf(
			'%s %s',
			number_format(round($bytes, $precision), 1),
			$units[$pow]
		);
	}
}
