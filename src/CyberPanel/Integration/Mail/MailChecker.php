<?php

namespace CyberPanel\Integration\Mail;

use CyberPanel\Integration\Mail\Client\Client;
use CyberPanel\Configuration\Configuration;
use CyberPanel\System\Executer;
use CyberPanel\Logging\Log;
use CyberPanel\Utils\Traits\HasSocketClient;

class MailChecker {

	use HasSocketClient;

	protected const CMD_PASSWORD = '
		kdialog --password "Please type password for %s" \
		--title "cyberPanel mail password" ';

	private static self $instance;

	private function __construct() {
		$this->builSocketClient();
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function run() : void {
		while (TRUE) {
			try {
				if (empty($mailbox)) {
					$mailbox = $this->getMailBox();
				}
				$data = [
					'folders' => $mailbox->getFolders(),
					'quota' => $mailbox->getQuota(),
					'errorOnConnect' => FALSE
				];
			} catch (\UnexpectedValueException $ex) {
				$data = ['errorOnConnect' => TRUE];
			}
			$this->sendToSocketServer(
				[
					'command' => 'mail.storemails',
					'parameters' => $data
				]
			);
			sleep(50);
		}
	}

	protected function getMailBox() : Client {
		$password = Executer::execAndGetResponse(
			sprintf(
				self::CMD_PASSWORD,
				Configuration::getInstance()->getSubSection('mail')->getUsername()
			)
		);
		Log::info(
			sprintf(
				'Starting mail checker for host %s',
				Configuration::getInstance()->getSubSection('mail')->getHost()
			)
		);

		return new Client(
			Configuration::getInstance()->getSubSection('mail')->getHost(),
			Configuration::getInstance()->getSubSection('mail')->getPort(),
			Configuration::getInstance()->getSubSection('mail')->getUsername(),
			$password,
		);
	}
}
