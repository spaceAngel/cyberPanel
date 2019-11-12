<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use CyberPanel\CyberPanel;

$server = IoServer::factory(
	new HttpServer(
		new WsServer(
			new CyberPanel()
		)
	),	
	8080
);

$server->run ();