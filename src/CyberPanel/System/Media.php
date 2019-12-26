<?php

namespace CyberPanel\System;

use CyberPanel\DataStructs\Id3;
use CyberPanel\System\ShellCommands\Media as Commands;

class Media {

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getCurrentPlayer() : ?string {
		$players = explode("\n", trim(Executer::execAndGetResponse(Commands::CMD_GETPLAYERS)));
		foreach ($players as $player) {
			if (
				!empty($player)
				&& trim(Executer::execAndGetResponse(
					sprintf(Commands::CMD_ISPLAYING, $player)
				)) == 'Playing'
			) {
				return $player;
			}
		}
		return !empty($players[0]) ? $players[0] : NULL;
	}

	public function getCurrentSong() : Id3 {
		//really one = due to assignation and test it to true
		if ($player = $this->getCurrentPlayer()) {
			$data = explode(
				"\n",
				Executer::execAndGetResponse(
					sprintf(Commands::CMD_CURRENTSONG, $player)
				)
			);

			$id3 = new Id3($data);
		} else {
			return new Id3();
		}
		return $id3;
	}

	public function getPosition() {
		//really one = due to assignation and test it to true
		if ($player = $this->getCurrentPlayer()) {
			return (int)Executer::execAndGetResponse(
				sprintf(Commands::CMD_CURRENTPOSITION, $player)
			);
		}

		return NULL;
	}

	public function getVolume() : int {
		return (int)Executer::execAndGetResponse(Commands::CMD_VOLUME);
	}

	public function getMuted() : bool {
		return Executer::execAndGetResponse(Commands::CMD_ISMUTED) != 'no';
	}

	public function volumeUp() : void {
		if (self::getVolume() >= 100) return;
		Executer::execAndGetResponse(Commands::CMD_VOLUMEUP);
	}

	public function volumeDown() : void {
		Executer::execAndGetResponse(Commands::CMD_VOLUMEDOWN);
	}

	public function volumeMute() : void {
		Executer::execAndGetResponse(Commands::CMD_VOLUMEMUTE);
	}

	public function volumeUnMute() : void {
		Executer::execAndGetResponse(Commands::CMD_VOLUMEUNMUTE);
	}


}