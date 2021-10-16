<?php

namespace CyberPanel\Server;

use  React\Http\Message\Response;
use React\EventLoop\Factory;
use React\Http\Server;
use Psr\Http\Message\ServerRequestInterface;
use CyberPanel\Server\Utils\Mime;
use CyberPanel\Security\SecurityManager;
use CyberPanel\Logging\Log;
use React\Http\Client\Request;
use CyberPanel\Events\EventManager;
use CyberPanel\Events\Events\Terminal\UnauthorizedConnectionEvent;

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
		try {
			$socket = new \React\Socket\Server('0.0.0.0:' . $this->port, $loop);
			$server->listen($socket);
			$loop->run();
		} catch (\RuntimeException $e) {
			Log::error('Cannot run web server. Port %s is already in use.', [$this->port]);
		}
	}

	protected function handleRequest(ServerRequestInterface $request) : Response {
		$uri = $request->getUri()->getPath();
		$isAccessible = $this->isAccessable($request, $uri);
		$file = $this->getFullFilePath($uri);
		if (file_exists($file) && $isAccessible) {
			return $this->handleGetFile($file, $request);
		} elseif ($uri == '/config.js' && $isAccessible) {
			return $this->handleConfigJs($request);
		} elseif ($uri == '/unauthorized' || !$isAccessible) {
			return $this->handleErrorUnauthorized($file, $request);
		} else {
			return $this->handleErrorNotFound($request);
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

	protected function handleGetFile(
		string $file,
		ServerRequestInterface $request
	) : Response {
		Log::info(
			'HTTP GET 200 %s %s',
			[
				$request->getUri()->getPath(),
				$request->getServerParams()['REMOTE_ADDR']
			]
		);
		return new Response(
			200,
			[Mime::getContentType($file)],
			file_get_contents($file)
		);
	}

	protected function getFullFilePath(string $file) : string {
		if ($file == '/') {
			$file = 'index.html';
		}
		return realpath($this->baseDir . $file);
	}

	protected function handleConfigJs(ServerRequestInterface $request) : Response {
		Log::info(
			'HTTP GET 200 config.js %s',
			[ $request->getServerParams()['REMOTE_ADDR'] ]
		);
		return new Response(
			200,
			[Mime::getContentType('/config.js')],
			include __DIR__ . '/tpl/config.js.php'
		);
	}

	protected function handleErrorNotFound(
		ServerRequestInterface $request
	) : Response {
		Log::error(
			'HTTP GET 404 %s %s',
			[
				$request->getUri()->getPath(),
				$request->getServerParams()['REMOTE_ADDR']
			]
		);
		$page = $this->getFullFilePath(self::PAGE_NOTFOUND);
		return new Response(
			404,
			[Mime::getContentType($page)],
			file_get_contents($page)
		);
	}

	protected function handleErrorUnauthorized(
		string $file,
		ServerRequestInterface $request
	) : Response {

		$page = $this->getFullFilePath(self::PAGE_UNAUTHORIZED);
		EventManager::getInstance()->event(
			new UnauthorizedConnectionEvent($request->getServerParams()['REMOTE_ADDR'])
		);
		Log::warn(
			'HTTP GET 401 %s %s',
			[
				$file,
				$request->getServerParams()['REMOTE_ADDR']
			]
		);
		return new Response(
			401,
			[Mime::getContentType($page)],
			file_get_contents($page)
		);
	}
}
