<?php

namespace CyberPanel;

use Ratchet\Http\HttpServer;
use Ratchet\Http\HttpServerInterface;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;
use GuzzleHttp\Psr7\Response;


class WebServer implements HttpServerInterface {

	protected $response;

	public function onClose($conn) {}
	public function onOpen(ConnectionInterface $conn, RequestInterface $request = null) {
		$this->response = new Response(200, [
				'Content-Type' => 'text/html; charset=utf-8',
		]);
		$conn->SEND('<pre>' . var_export($request, TRUE));
		$conn->close();

	}

	function onMessage(ConnectionInterface $from, $msg) {
		var_dump($msg);
	}
	function onError(ConnectionInterface $conn, \Exception $e) {}

}
