<?php

namespace CyberPanel\Integration\Media\System;

interface ShellCommands {

	// phpcs:disable Generic.Files.LineLength
	const CMD_VOLUME = "pacmd list-sinks|grep -A 15 '* index'| awk '/volume: front/{ print $5 }' | sed 's/[%|,]//g'";
	const CMD_ISMUTED = "pacmd list-sinks|grep -A 15 '* index'|awk '/muted:/{ print $2 }'";
	const CMD_VOLUMEUP = 'pactl set-sink-volume $(pactl list short sinks | grep RUNNING  | cut -f1) +5%';
	const CMD_VOLUMEDOWN = 'pactl set-sink-volume $(pactl list short sinks | grep RUNNING| cut -f1) -5%';
	const CMD_VOLUMEMUTE = 'pactl set-sink-mute $(pactl list short sinks | grep RUNNING  | cut -f1) 1';
	const CMD_VOLUMEUNMUTE = 'pactl set-sink-mute $(pactl list short sinks | grep RUNNING| cut -f1) 0';

	const CMD_GETPLAYERS = "qdbus | egrep -i 'org.mpris.MediaPlayer'";
	const CMD_ISPLAYING = "qdbus %s /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.PlaybackStatus";

	const CMD_CURRENTSONG = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Metadata";
	const CMD_CURRENTPOSITION = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Position";

	const CMD_NEXT = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Next";
	const CMD_PREVIOUS = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Previous";
	const CMD_STOP = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Stop";
	const CMD_PLAY = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Play";
	const CMD_PAUSE = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Pause";

	// phpcs:enable

}
