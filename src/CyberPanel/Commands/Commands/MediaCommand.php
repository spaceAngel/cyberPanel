<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Media;

class MediaCommand extends BaseCommand {
	public function run() : array {
		switch ($this->parameters[0]) {
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
		}

		$id3 = Media::getInstance()->getCurrentSong();
		return [
			'volume' => Media::getInstance()->getVolume(),
			'muted' => Media::getInstance()->getMuted(),
			'currentsong' => $id3->getName(),
			'length' => $id3->getLength(),
			'position' => Media::getInstance()->getPosition(),
		];
	}


}
