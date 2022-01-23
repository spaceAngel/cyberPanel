<?php

namespace CyberPanel\Utils;

class Files {

	public static function loadBinary(string $path) : ?string {
		if (file_exists($path)) {
			$binary = file_get_contents($path);
			$binary = base64_encode($binary);
			$pathinfo = pathinfo($path);
			switch ($pathinfo['extension']) {
				case 'xpm':
					$binary = self::convertFromXpm($path);
					$pathinfo['extension'] = 'png';
					break;
				case 'svg':
					$binary = base64_encode(file_get_contents($path));
					$pathinfo['extension'] = 'image/svg+xml';
					break;
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
