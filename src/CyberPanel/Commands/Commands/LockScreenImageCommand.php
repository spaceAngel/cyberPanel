<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\KdeSettings;

class LockScreenImageCommand extends BaseCommand {
	public function run() : array {

		$wallpaper = Executer::execAndGetResponse(KdeSettings::CMD_LOCKSCREENIMAGE);
		if (file_exists($wallpaper)) {
			$binary = file_get_contents($wallpaper);
			$binary = base64_encode($binary);
			return [
				'binary' => $binary,
				'type' => $this->getImageType($wallpaper)
			];
		}
		return [];
	}

	protected function getImageType(string $file) : string {
		switch (exif_imagetype($file)) {
			case IMAGETYPE_JPEG:
				return 'imagge/jpeg';
		}
	}
}
