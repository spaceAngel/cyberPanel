<?php

namespace CyberPanel\Integration\Mail\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Integration\Mail\MailManager;


class StoreMailsCommand extends BaseCommand{

	public function run() : array {
		if ($this->parameters['errorOnConnect'] == FALSE) {
			MailManager::getInstance()->storeFolders(
				$this->parameters['folders']
			);
			MailManager::getInstance()->setQuota(
				$this->parameters['quota']
			);
		}
		MailManager::getInstance()->setErrorOnConnect(
			$this->parameters['errorOnConnect']
		);
		return [];
	}
}
