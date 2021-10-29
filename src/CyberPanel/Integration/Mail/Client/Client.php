<?php

namespace CyberPanel\Integration\Mail\Client;

use PhpImap\Mailbox;

class Client {

	private const CONNECTION_STRING = '{%s:%s/imap/ssl/novalidate-cert}INBOX';

	protected $connection;

	protected $mailbox;

	public function __construct(
		string $host,
		string $port,
		string $username,
		string $password
	) {
		$connectionString = sprintf(
			self::CONNECTION_STRING,
			$host,
			$port
		);
		$this->connection = new Mailbox(
			$connectionString,
			$username,
			$password
		);
		$this->mailbox = $connectionString;
		$this->connection->setTimeouts(5, [IMAP_OPENTIMEOUT, IMAP_READTIMEOUT]);
	}

	public function getQuota() : float {
		$usage = $this->connection->getQuotaUsage('INBOX');
		$limit = $this->connection->getQuotaLimit('INBOX');
		return 100 * $usage / $limit;
	}

	public function getFolders() : array {
		$rslt = [];
		foreach ($this->getMailboxes() as $mailbox) {
			$this->connection->switchMailbox($mailbox);
			$ids = $this->connection->searchMailbox('ALL');
			$nameParsed = explode('.', $mailbox);
			$rslt[] = [
				'unread' => $this->connection->getMailboxInfo()->Unread,
				'emails' => $this->getEmails($ids),
				'nesting' => count($nameParsed) - 1,
				'name' => array_pop($nameParsed),
			];
		}
		$this->connection->switchMailbox($this->mailbox);
		return $rslt;
	}

	protected function getEmails(array $ids) : array {
		$rslt = [];

		$withAttachments = $this->connection->searchMailbox(
			'TEXT "Content-Type: multipart/mixed"'
		);
		$emails = !empty($ids) ? $this->connection->getMailsInfo($ids) : [];

		foreach ($emails as $i => $email) {
			$key = str_pad($email->udate, 20, '0', STR_PAD_LEFT) . str_pad($i, 4, '0');
			$rslt[$key] = [
				'subject' => $email->subject,
				'from' => Decorator::from($email->from),
				'size' => Decorator::size($email->size),
				'date' => Decorator::date($email->udate),
				'answered' => (bool)$email->answered,
				'unread' => !(bool)$email->seen,
				'attachment' => in_array($email->uid, $withAttachments),
			];
		}
		krsort($rslt);
		return array_values($rslt);
	}

	protected function hasAttachment($uid) : bool {
		$fullEmail = $this->connection->getMail($uid);
		foreach ($fullEmail->getAttachments() as $attachment) {
			if ($attachment->disposition == 'attachment') {
				return TRUE;
			}
		}
		return FALSE;

	}

	protected function getMailboxes() : array {
		$rslt = [];
		foreach ($this->connection->getMailboxes('*') as $mailbox) {
			$rslt[] = $mailbox['shortpath'];
		}
		sort($rslt, SORT_LOCALE_STRING);
		return $rslt;
	}
}
