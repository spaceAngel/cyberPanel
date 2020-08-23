<?php

namespace CyberPanel\Server;

use  React\Http\Message\Response;;
use React\EventLoop\Factory;
use React\Http\Server;
use Psr\Http\Message\ServerRequestInterface;
use CyberPanel\Server\Utils\Mime;

class WebServer  {

	protected $port;

	protected $baseDir = 'build/';

	public function __construct(int $port = 8082) {
		$this->port = $port;
	}

	public function run() {
		$loop = Factory::create();
		$server = new Server($loop, function (ServerRequestInterface $request) {
			return $this->handleRequest($request);
		});
		$socket = new \React\Socket\Server('0.0.0.0:' . $this->port, $loop);
		$server->listen($socket);
		$loop->run();
	}

	protected function handleRequest(ServerRequestInterface $request) : Response {
		$file = $this->getFullFilePath($request->getUri()->getPath());
		if (file_exists($file)) {
			return new Response(
				200,
				[Mime::getContentType($file)],
				file_get_contents($file)
			);
		}
	}

	protected function getFullFilePath(string $file) : string {
		if ($file == '/') {
			$file = 'index.html';
		}
		return realpath($this->baseDir . $file);
	}


}
