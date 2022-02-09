<?php

namespace CyberPanel\Integration\Clipboard;

use CyberPanel\System\Executer;

class Clipboard {

	//phpcs:disable Generic.Files.LineLength
	protected const CMD_HISTORY = 'qdbus org.kde.klipper /klipper org.kde.klipper.klipper.getClipboardHistoryItem %s;';
	protected const CMD_SET_CONTENT = 'qdbus org.kde.klipper /klipper org.kde.klipper.klipper.setClipboardContents %s';
	protected const CMD_DELIMITER = 'echo "' . self::DELIMITER . '";';

	protected const DELIMITER = '|||||';
	//phpcs:enable


	protected const HISTORY_LIMIT = 10;


	public static function getHistory() : array {
		$cmd = '';
		for ($i = 0; $i <= self::HISTORY_LIMIT; $i++) {
			$cmd .= sprintf(self::CMD_HISTORY, $i);
			$cmd .= self::CMD_DELIMITER;
		}

		$rslt = explode(
			self::DELIMITER,
			Executer::execAndGetResponse($cmd)
		);
		foreach ($rslt as $i => $item) {
			$rslt[$i] = preg_replace('/^\n/', ' ', $item);
		};
		return $rslt;
	}

	public static function setContent(string $content) : void {
		Executer::exec(
			sprintf(
				self::CMD_SET_CONTENT,
				escapeshellarg($content)
			)
		);
	}
}

