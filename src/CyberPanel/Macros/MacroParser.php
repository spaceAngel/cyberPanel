<?php

namespace CyberPanel\Macros;

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
			if (array_key_exists('caption', $data)) $macro->setCaption($data['caption']);
			if (array_key_exists('command', $data)) $macro->setCommand($data['command']);
			if (array_key_exists('icon', $data)) $macro->setIcon($data['icon']);
			if (array_key_exists('position', $data)) $macro->setPosition($data['position']);
			if (array_key_exists('notification', $data)) {
				$macro->setNotification($data['notification']);
			}
			if (empty($macro->getIcon())) {
				$this->loadIcon($macro);
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
}
