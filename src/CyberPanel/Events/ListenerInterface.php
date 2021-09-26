<?php

namespace CyberPanel\Events;

interface ListenerInterface {

	public function onEvent(Event $event) : void;

	public function listenOn() : string;


}

