<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Media;

class MediaCommand extends BaseCommand {
	public function run() : array {
		switch ($this->parameters[0]) {
		}

		$id3 = Media::getInstance()->getCurrentSong();
		return [
			'volume' => Media::getInstance()->getVolume(),
			'currentsong' => $id3->getName(),
			'length' => $id3->getLength(),
			'position' => Media::getInstance()->getPosition(),
		];
	}


}
