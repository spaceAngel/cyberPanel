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
				!empty($player) && $this->isPlayerPlaying($player)
			) {
				return $player;
			}
		}

		//now when not playing player found, try to found first paused player
		foreach ($players as $player) {
			if (
				!empty($player) && $this->isPlayerPlaying($player, TRUE)
			) {
				return $player;
			}
		}

		return !empty($players[0]) ? $players[0] : NULL;
	}

	public function isPlayerPlaying(string $player, bool $includePaused = FALSE) : bool {
		$playingStates = ['Playing'];
		if ($includePaused) {
			$playingStates[] = 'Paused';
		}
		return in_array(
			trim(
				Executer::execAndGetResponse(
					sprintf(Commands::CMD_ISPLAYING, $player)
				)
			),
			$playingStates
		);
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
		$sink = (int)Executer::execAndGetResponse(Commands::CMD_GETSINK);
		return (int)Executer::execAndGetResponse(
			sprintf(Commands::CMD_VOLUME, $sink)
		);
	}

	public function getMuted() : bool {
		$sink = (int)Executer::execAndGetResponse(Commands::CMD_GETSINK);
		return Executer::execAndGetResponse(
			sprintf(Commands::CMD_ISMUTED, $sink)
		) != 'no';
	}

	public function volumeUp() : void {
		if (self::getVolume() >= 100) return;
		$sink = (int)Executer::execAndGetResponse(Commands::CMD_GETSINK);
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_VOLUMEUP, $sink)
		);
	}

	public function volumeDown() : void {
		$sink = (int)Executer::execAndGetResponse(Commands::CMD_GETSINK);
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_VOLUMEDOWN, $sink)
		);
	}

	public function volumeMute() : void {
		$sink = (int)Executer::execAndGetResponse(Commands::CMD_GETSINK);
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_VOLUMEMUTE, $sink)
		);
	}

	public function volumeUnMute() : void {
		$sink = (int)Executer::execAndGetResponse(Commands::CMD_GETSINK);
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_VOLUMEUNMUTE, $sink)
		);
	}

	public function stop() : void {
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_STOP, $this->getCurrentPlayer())
		);
	}

	public function play() : void {
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_PLAY, $this->getCurrentPlayer())
		);
	}

	public function pause() : void {
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_PAUSE, $this->getCurrentPlayer())
		);
	}

	public function previous() : void {
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_PREVIOUS, $this->getCurrentPlayer())
		);
	}

	public function next() : void {
		Executer::execAndGetResponse(
			sprintf(Commands::CMD_NEXT, $this->getCurrentPlayer())
		);
	}


}
