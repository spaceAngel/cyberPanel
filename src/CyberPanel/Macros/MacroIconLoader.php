<?php

namespace CyberPanel\Macros;

use CyberPanel\Utils\Files;

class MacroIconLoader {

	protected static $dirs = [
		'/usr/share/icons/hicolor/64x64/apps/',
		'/usr/share/icons/hicolor/48x48/apps/',
		'/var/lib/app-info/icons/ubuntu-focal-universe/64x64/',
	];

	protected static $modified = [
		'krusader' => 'krusader_user',
	];

	protected static $customIcons = [
		'icon.xpm'		//e.g. eclipse
	];

	public static function loadIcon(string $command) {
		$commandRaw = explode(' ', $command);
		$commandPathRaw = array_shift($commandRaw);
		$commandPathRaw = pathinfo($commandPathRaw);
		$binary = self::loadSystemIcon($commandPathRaw['basename']);
		if (!empty($binary)) {
			return $binary;
		}
		$binary = self::loadIconFromFolder(
			$commandPathRaw['dirname'],
			$commandPathRaw['basename']
		);
		if (!empty($binary)) {
			return $binary;
		}

	}

	protected static function loadIconFromFolder(
		string $folder,
		string $basename
	) : ?string {
		foreach (self::getFileNames($basename) as $filename) {
			$path = sprintf('%s/%s.png', $folder, $filename);
			$binary = Files::loadBinary($path);
			if (!empty($binary)) {
				return $binary;
			}
		}

		foreach (self::$customIcons as $icon) {
			$path = sprintf('%s/%s', $folder, $icon);
			$binary = Files::loadBinary($path);
			if (!empty($binary)) {
				return $binary;
			}
		}
		return NULL;
	}

	protected static function loadSystemIcon(string $basename) : ?string {
		foreach (self::$dirs as $dir) {
			foreach (self::getFileNames($basename) as $filename) {
				$path = sprintf('%s/%s.png', $dir, $filename);
				$binary = Files::loadBinary($path);
				if (!empty($binary)) {
					return $binary;
				}
			}
		}
		return NULL;
	}

	protected static function getFileNames(string $basename) : array {
		return [
			$basename,
			sprintf('%s_%s', $basename, $basename),
			str_replace(
				array_keys(self::$modified),
				array_values(self::$modified),
				$basename,
			),
			'icon',
		];
	}
}
