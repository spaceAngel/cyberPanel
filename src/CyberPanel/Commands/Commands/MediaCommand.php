<?php

namespace CyberPanel\Commands\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\System\Executer;
use CyberPanel\System\ShellCommands\Media;

class MediaCommand extends BaseCommand {
	public function run() : array {
		switch ($this->parameters[0]) {

		}

		$player = $this->getCurrentPlayer();
		if (!empty($player)) {
			$id3 = $this->getCurrentSong($player);
			return [
				'volume' => (int)Executer::execAndGetResponse(Media::CMD_VOLUME),
				'currentsong' => $this->getSongName($id3),
				'length' => $id3['length'],
				'position' => (int)Executer::execAndGetResponse(
					sprintf(Media::CMD_CURRENTPOSITION, $player)
				),
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

	private function getCurrentPlayer() : ?string {
		$players = explode("\n", trim(Executer::execAndGetResponse(Media::CMD_GETPLAYERS)));
		foreach ($players as $player) {
			if (
				trim(Executer::execAndGetResponse(
					sprintf(MEDIA::CMD_ISPLAYING, $player)
				)) == 'Playing'
			) {
				return $player;
			}
		}
		return NULL;
	}

	private function getSongName(array $id3) : string {
		return $id3['author'] . ' - ' . $id3['title'];
	}

	private function getCurrentSong(string $player) : array {
		$id3 = [];
		$rawData = explode(
			"\n",
			Executer::execAndGetResponse(sprintf(Media::CMD_CURRENTSONG, $player))
		);
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
