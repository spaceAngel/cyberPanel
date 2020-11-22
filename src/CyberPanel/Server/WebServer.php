<?php

namespace CyberPanel\Server;

use  React\Http\Message\Response;
use React\EventLoop\Factory;
use React\Http\Server;
use Psr\Http\Message\ServerRequestInterface;
use CyberPanel\Server\Utils\Mime;
use CyberPanel\Security\SecurityManager;

class WebServer  {

	const PAGE_NOTFOUND = 'errors/notfound.html';
	const PAGE_UNAUTHORIZED = 'errors/unauthorized.html';

	protected $port;

	protected $baseDir = 'build/';

	protected $publicFiles = [
		'/css/app.min.css',
		'/fonts/logo.ttf'
	];

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
		$uri = $request->getUri()->getPath();
		$isAccessible = $this->isAccessable($request, $uri);
		$file = $this->getFullFilePath($uri);
		if (file_exists($file) && $isAccessible) {
			return new Response(
				200,
				[Mime::getContentType($file)],
				file_get_contents($file)
			);
		} elseif ($uri == '/config.js' && $isAccessible) {
			return $this->handleConfigJs();
		} elseif ($uri == '/unauthorized' || !$isAccessible) {
			return $this->handleErrorUnauthorized();
		} else {
			return $this->handleErrorNotFound();
		}
	}

	public function isAccessable(
		ServerRequestInterface $request,
		string $uri
	) : bool {
		return (
			SecurityManager::getInstance()->checkHttpAccess($request)
			|| in_array($uri, $this->publicFiles)
		);
	}

	protected function getFullFilePath(string $file) : string {
		if ($file == '/') {
			$file = 'index.html';
		}
		return realpath($this->baseDir . $file);
	}

	protected function handleConfigJs() : Response {
		return new Response(
			200,
			[Mime::getContentType('/config.js')],
			include __DIR__ . '/tpl/config.js.php'
		);
	}

	protected function handleErrorNotFound() : Response {
		$page = $this->getFullFilePath(self::PAGE_NOTFOUND);
		return new Response(
			404,
			[Mime::getContentType($page)],
			file_get_contents($page)
		);
	}

	protected function handleErrorUnauthorized() : Response {
		$page = $this->getFullFilePath(self::PAGE_UNAUTHORIZED);
		return new Response(
			401,
			[Mime::getContentType($page)],
			file_get_contents($page)
		);
	}
}
