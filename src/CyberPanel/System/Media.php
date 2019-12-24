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
				trim(Executer::execAndGetResponse(
						sprintf(Commands::CMD_ISPLAYING, $player)
				)) == 'Playing'
			) {
				return $player;
			}
		}
		return $players[0];
	}

	public function getCurrentSong() : Id3 {
		$id3 = [];
		$data = explode(
			"\n",
			Executer::execAndGetResponse(
				sprintf(Commands::CMD_CURRENTSONG, $this->getCurrentPlayer())
			)
		);

		$id3 = new Id3($data);
		return $id3;
	}

	public function getPosition() {
		return (int)Executer::execAndGetResponse(
				sprintf(Commands::CMD_CURRENTPOSITION, $this->getCurrentPlayer())
		);
	}

	public function getVolume() : int {
		return (int)Executer::execAndGetResponse(Commands::CMD_VOLUME);
	}

}
