<?php

namespace CyberPanel\Macros;

class MacroIconLoader {

	protected static $dirs = [
		'/usr/share/icons/hicolor/64x64/apps/',
		'/var/lib/app-info/icons/ubuntu-focal-universe/64x64/'
	];

	protected static $modified = [
		'krusader' => 'krusader_user',
		'eclipse' => 'redeclipse_redeclipse',
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
			$binary = self::loadBinary($path);
			if (!empty($binary)) {
				return $binary;
			}
		}

		foreach (self::$customIcons as $icon) {
			$path = sprintf('%s/%s', $folder, $icon);
			$binary = self::loadBinary($path);
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
				$binary = self::loadBinary($path);
				if (!empty($binary)) {
					return $binary;
				}
			}
		}
		return NULL;
	}

	protected static function loadBinary(string $path) : ?string {
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

	protected static function getFileNames(string $basename) : array {
		return [
			$basename,
			sprintf('%s_%s', $basename, $basename),
			str_replace(
				array_keys(self::$modified),
				array_values(self::$modified),
				$basename,
			)
		];
	}
}
