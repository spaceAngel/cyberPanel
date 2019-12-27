<?php

namespace CyberPanel\System\ShellCommands;

interface Media {

	// phpcs:disable Generic.Files.LineLength
	const CMD_VOLUME = "pactl list sinks | grep '^[[:space:]]Volume:' | head -n 1 |sed -e 's,.* \\([0-9][0-9]*\\)%.*,\\1,'";
	const CMD_ISMUTED = "pactl list sinks | grep '^[[:space:]]Mute:' | head -n 1| sed -e 's/\tMute: //g'";
	const CMD_VOLUMEUP = 'pactl set-sink-volume $(pactl list short sinks | head -n1 | cut -f1) +5%';
	const CMD_VOLUMEDOWN = 'pactl set-sink-volume $(pactl list short sinks | head -n1 | cut -f1) -5%';
	const CMD_VOLUMEMUTE = 'pactl set-sink-mute $(pactl list short sinks | head -n1 | cut -f1) 1';
	const CMD_VOLUMEUNMUTE = 'pactl set-sink-mute $(pactl list short sinks | head -n1 | cut -f1) 0';

	const CMD_GETPLAYERS = "qdbus | egrep -i 'org.mpris.MediaPlayer'";
	const CMD_ISPLAYING = "qdbus %s /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.PlaybackStatus";

	const CMD_CURRENTSONG = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Metadata";
	const CMD_CURRENTPOSITION = "qdbus %s  /org/mpris/MediaPlayer2 org.mpris.MediaPlayer2.Player.Position";
	// phpcs:enable

}
