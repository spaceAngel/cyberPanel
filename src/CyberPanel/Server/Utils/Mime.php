<?php

namespace CyberPanel\Server\Utils;

final class Mime {

	private static $mimes = [
		'css' => 'text/css',
		'html' => 'text/html',
		'js' => 'text/javascript',
	];

	private function __construct() {
	}

	public static function getContentType(string $path) : ?string {
		$path = pathinfo($path);
		if (array_key_exists($path['extension'], self::$mimes)) {
			return self::$mimes[$path['extension']];
		}
		return NULL;
	}
}
