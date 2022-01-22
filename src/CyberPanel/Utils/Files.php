<?php

namespace CyberPanel\Utils;

class Files {

	public static function loadBinary(string $path) : ?string {
		if (file_exists($path)) {
			$binary = file_get_contents($path);
			$binary = base64_encode($binary);
			$pathinfo = pathinfo($path);
			if ($pathinfo['extension'] == 'xpm') {
				$binary = self::convertFromXpm($path);
				$pathinfo['extension'] = 'png';
			}
			return sprintf(
				'%s;base64,%s',
				$pathinfo['extension'],
				$binary
			);
		}
		return NULL;
	}

	protected function convertFromXpm(string $path) {
		if (file_exists($path)) {
			$img = imagecreatefromxpm($path);
			ob_start();
			imagepng($img);
			imagedestroy($img);
			$rslt = ob_get_contents();
			ob_end_clean();
			return base64_encode($rslt);
		}
	}

}
