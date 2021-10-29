<?php

namespace CyberPanel\Integration\Mail\Commands;

use CyberPanel\Commands\BaseCommand;
use CyberPanel\Integration\Mail\MailManager;


class GetMailsCommand extends BaseCommand{

	public function run() : array {
		return [
			'folders' => MailManager::getInstance()->getFolders(),
			'unread' => MailManager::getInstance()->getUnreadCount(),
			'quota' => MailManager::getInstance()->getQuota(),
			'errorOnConnect' => MailManager::getInstance()->getErrorOnConnect(),
		];
	}
}
