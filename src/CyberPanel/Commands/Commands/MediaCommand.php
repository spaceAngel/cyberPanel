<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Media;

class MediaCommand extends BaseCommand {
	public function run() : array {
		switch ($this->parameters[0]) {

		}

		if (!empty(Executer::execAndGetResponse(Media::CMD_GETPLAYERS))) {
			$id3 = $this->getCurrentSong();
			return [
				'volume' => (int)Executer::execAndGetResponse(Media::CMD_VOLUME),
				'currentsong' => $this->getSongName($id3),
				'length' => $id3['length'],
				'position' => (int)Executer::execAndGetResponse(Media::CMD_CURRENTPOSITION),
			];
		} else {
			return [
				'volume' => (int)Executer::execAndGetResponse(Media::CMD_VOLUME),
				'currentsong' => '',
				'length' => 1,
				'position' => 1,
			];
		}
	}

	private function getSongName(array $id3) : string {
		return $id3['author'] . ' - ' . $id3['title'];
	}

	private function getCurrentSong() : array {
		$id3 = [];
		$rawData = explode("\n", Executer::execAndGetResponse(Media::CMD_CURRENTSONG));
		foreach ($rawData as $dataItem) {

			if (strpos($dataItem, 'xesam:artist') === 0) {
				$id3['author'] = substr($dataItem, 14);
			}

			if (strpos($dataItem, 'xesam:title') === 0) {
				$id3['title'] = substr($dataItem, 13);
			}

			if (strpos($dataItem, 'mpris:length') === 0) {
				$id3['length'] = (int)substr($dataItem, 14);
			}
		}
		return $id3;
	}
}
