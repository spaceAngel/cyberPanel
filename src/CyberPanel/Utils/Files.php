<?php

namespace CyberPanel\Utils;

class Files {

	public static function loadBinary(string $path) : ?string {
		if (file_exists($path)) {
			$binary = file_get_contents($path);
			$binary = base64_encode($binary);
			$pathinfo = pathinfo($path);
			return sprintf(
				'%s;base64,%s',
				$pathinfo['extension'],
				$binary
			);
		}
		return NULL;
	}

}
