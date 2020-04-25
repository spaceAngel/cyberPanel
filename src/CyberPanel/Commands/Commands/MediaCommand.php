<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Media;

class MediaCommand extends BaseCommand {
	public function run() : array {
		if (!empty($this->parameters)) {
			$this->handleCommand($this->parameters[0]);
		}

		$id3 = Media::getInstance()->getCurrentSong();
		$media = Media::getInstance();
		return [
			'volume' => $media->getVolume(),
			'muted' => $media->getMuted(),
			'currentsong' => $id3->getName(),
			'length' => $id3->getLength(),
			'position' => $media->getPosition(),
			'playing' => $media->getCurrentPlayer() ? $media->isPlayerPlaying(
				$media->getCurrentPlayer()
			) : FALSE
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
