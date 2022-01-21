<?php

namespace CyberPanel\Integration\Mail;

use CyberPanel\Commands\CommandResolver;
use CyberPanel\Integration\Mail\Commands\StoreMailsCommand;
use CyberPanel\Integration\Mail\Commands\GetMailsCommand;
use CyberPanel\Configuration\ConfigurationLoader as ConfLoader;
use \CyberPanel\Integration\Mail\Configuration\ConfigurationLoader;

class MailModule {

	private function __construct() {
	}

	public static function init() : void {
		CommandResolver::getInstance()->registerCommand(
			'mail.storemails', StoreMailsCommand::class
		);
		CommandResolver::getInstance()->registerCommand(
			'mail.getmails', GetMailsCommand::class
		);

		ConfLoader::registerSubLoader(
			'mail',
			ConfigurationLoader::class
		);

		self::detachChecker();
	}

	private static function detachChecker() : void {
		if (0 !== pcntl_fork()) {
		} else {
			MailChecker::getInstance()->run();
		}
	}

}
