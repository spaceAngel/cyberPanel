<?php

namespace CyberPanel\Integration;

class ModuleLoader {

	public static function loadModules() : void {
		$files = dir(__DIR__);
		while ($file = $files->read()) {
			if (
				is_dir(__DIR__ . DIRECTORY_SEPARATOR . $file)
			) {
				$class = "CyberPanel\\Integration\\${file}\\${file}Module";
				if (
					class_exists($class)
					&& method_exists($class, 'init')
				) {
					$class::init();
				}
			}
		}
	}

}
