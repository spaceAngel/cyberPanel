<?php

namespace CyberPanel;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use CyberPanel\Security\SecurityManager;
use CyberPanel\Logging\Log;
use CyberPanel\Commands\CommandResolver;
use CyberPanel\Events\EventManager;
use CyberPanel\Events\Events\Terminal\TerminalConnectedEvent;
use CyberPanel\Events\Events\Terminal\UnauthorizedConnectionEvent;
use CyberPanel\Events\Events\Terminal\TerminalDisconnectedEvent;

class WsServer implements MessageComponentInterface {
	protected $clients;
	public function __construct() {
		$this->clients = new \SplObjectStorage ();
	}

	public function onOpen(ConnectionInterface $connection) {
		// Store the new connection to send messages to later
		if (!SecurityManager::getInstance()->checkSocketAccess($connection)) {
			EventManager::getInstance()->event(
				new UnauthorizedConnectionEvent($connection->remoteAddress)
			);
			Log::warn('Unauthorized client %s', [$connection->remoteAddress]);
			$connection->send('unauthorized');
			$connection->close();
		} else {
			$this->clients->attach($connection);
			EventManager::getInstance()->event(
				new TerminalConnectedEvent($connection->remoteAddress)
			);
			Log::info('Client %s connected', [$connection->remoteAddress]);
		}
	}

	/**
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function onMessage(ConnectionInterface $conn, $msg) {
		$commands = CommandResolver::getInstance()->parse(
			json_decode($msg)
		);

		foreach ($commands as $command) {
			$conn->send(
				$command->buildResponse()
			);
		}
	}

	public function onClose(ConnectionInterface $connection) {
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach($connection);
		EventManager::getInstance()->event(
			new TerminalDisconnectedEvent($connection->remoteAddress)
		);
		Log::info('Client %s diconnected', [$connection->remoteAddress]);
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
