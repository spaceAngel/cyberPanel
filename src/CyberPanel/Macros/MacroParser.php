<?php

namespace CyberPanel\Macros;

use CyberPanel\Utils\Files;

class MacroParser {

	private static self $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return  self::$instance;
	}

	public function parse(array $data) : Macro {
		$macro = new Macro();
		if (array_key_exists('delimiter', $data)) {
			$macro->setIsDelimiter();
		} elseif (array_key_exists('space', $data)) {
			$macro->setIsSpace();
		} else {
			if (array_key_exists('library', $data)) {
				$data = array_merge(
					Librarian::getInstance()->getMacroFromLibrary($data['library']),
					$data
				);
			}
			if (array_key_exists('caption', $data)) $macro->setCaption($data['caption']);
			if (array_key_exists('command', $data)) $macro->setCommand($data['command']);
			$this->handleIconResolving($macro, $data);
			if (array_key_exists('position', $data)) $macro->setPosition($data['position']);
			if (array_key_exists('notification', $data)) {
				$macro->setNotification($data['notification']);
			}
			if (array_key_exists('checkEnabledFunction', $data)) {
				$macro->setCheckEnabledFunction($data['checkEnabledFunction']);
			}
		}

		return $macro;
	}

	public function loadIcon(Macro $macro) {
		$iconBinary = MacroIconLoader::loadIcon($macro->getCommand());
		if (!empty($iconBinary)) {
			$macro->setIconImage($iconBinary);
		}
	}

	protected function handleIconResolving(Macro $macro, array $data) : void {
		if (array_key_exists('icon', $data)) {
			if (file_exists($data['icon'])) {
				$macro->setIconImage(
					Files::loadBinary($data['icon'])
				);
			} else {
				$macro->setIcon($data['icon']);
			}
		}

		if (empty($macro->getIcon()) && empty($macro->getIconImage())) {
			$this->loadIcon($macro);
		}

		if (array_key_exists('subIcon', $data)) {
			$macro->setSubIconImage(
				Files::loadBinary($data['subIcon'])
			);
		}
	}
}
