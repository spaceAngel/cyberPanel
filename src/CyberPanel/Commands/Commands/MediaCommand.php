<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Media;

class MediaCommand extends BaseCommand {
	public function run() : array {
		$this->handleCommand($this->parameters[0]);

		$id3 = Media::getInstance()->getCurrentSong();
		return [
			'volume' => Media::getInstance()->getVolume(),
			'muted' => Media::getInstance()->getMuted(),
			'currentsong' => $id3->getName(),
			'length' => $id3->getLength(),
			'position' => Media::getInstance()->getPosition(),
			'playing' => Media::getInstance()->isPlayerPlaying(
				Media::getInstance()->getCurrentPlayer()
			)
		];
	}

	/**
	 *
	 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
	 */
	private function handleCommand(string $command = NULL) : void {
		switch ($command) {
			case 'volumeup':
				Media::getInstance()->volumeUp();
				break;
			case 'volumedown':
				Media::getInstance()->volumeDown();
				break;
			case 'volumemute':
				Media::getInstance()->volumeMute();
				break;
			case 'volumeunmute':
				Media::getInstance()->volumeUnMute();
				break;
			case 'stop':
				Media::getInstance()->stop();
				break;
			case 'play':
				Media::getInstance()->play();
				break;
			case 'pause':
				Media::getInstance()->pause();
				break;
			case 'next':
				Media::getInstance()->next();
				break;
			case 'previous':
				Media::getInstance()->previous();
				break;
		}
	}


}
