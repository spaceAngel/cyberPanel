<?php

namespace CyberPanel;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use CyberPanel\Commands\CommandParser;

class WsServer implements MessageComponentInterface {
	protected $clients;
	public function __construct() {
		$this->clients = new \SplObjectStorage ();
	}

	public function onOpen(ConnectionInterface $conn) {
		// Store the new connection to send messages to later
		$this->clients->attach ( $conn );

		echo "New connection! ({$conn->resourceId})\n";
	}

	/**
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function onMessage(ConnectionInterface $conn, $msg) {
		$commands = CommandParser::getInstance()->parse(
			json_decode($msg)
		);

		foreach ($commands as $command) {
			$this->sendMessage(
				$command->buildResponse()
			);
		}

	}

	public function onClose(ConnectionInterface $conn) {
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach($conn);

		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";
		$conn->close ();
	}

	public function sendMessage(string $message) {
		foreach ($this->clients as $client) {
			$client->send($message);
		}
	}
}
