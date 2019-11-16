<?php

namespace CyberPanel\Commands;

interface Command {

	public function buildResponse() : string;

	public function setInvokingCommand(string $command) : void;

	public function getInvokingCommand() : string;

}
