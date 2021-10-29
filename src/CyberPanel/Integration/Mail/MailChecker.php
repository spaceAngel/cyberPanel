<?php

namespace CyberPanel\Integration\Mail;

use PhpImap\Mailbox;
use CyberPanel\Integration\Mail\Client\Client;
use PhpImap\Exceptions\ConnectionException;
use CyberPanel\Configuration\Configuration;
use CyberPanel\System\Executer;
use CyberPanel\Logging\Log;

class MailChecker {

	protected const CMD_PASSWORD = '
		kdialog --password "Please type password for %s" \
		--title "cyberPanel mail password" ';

	private static self $instance;

	private function __construct() {
	}

	public static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function run(int $port) : void {
		$client = new \WebSocket\Client("ws://127.0.0.1:" . $port);
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
			$client->text(
				json_encode(
					[
						'command' => 'mail.storemails',
						'parameters' => $data
					]
				)
			);
			sleep(50);
		}

		$client->close();
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
