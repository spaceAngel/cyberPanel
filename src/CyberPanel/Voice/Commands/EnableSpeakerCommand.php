<?php

namespace CyberPanel\Voice\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Voice\Speaker;

class EnableSpeakerCommand extends BaseCommand {


	public function __construct(string $invokingCommand, array $parameters = []) {
		parent::__construct($invokingCommand, $parameters);
	}

	public function run() : array {
		if (
			count($this->parameters) > 0
		) {
			Speaker::getInstance()->setEnabled((bool)$this->parameters[0]);
		}

		return ['enabled' => Speaker::getInstance()->getEnabled()];

	}

}
