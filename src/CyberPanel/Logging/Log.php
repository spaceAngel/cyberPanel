<?php

namespace CyberPanel\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class Log {

	const FORMAT_LOG = "%datetime% | %level_name% | %message% \n";
	const FORMAT_DATETIME = 'Y-n-j H:i:s';

	protected static self $instance;

	protected Logger $logger;

	protected function __construct() {
		$this->logger = new Logger('CyberPanel');
	}

	public static function enableConsoleOutput() {
		$stream = new StreamHandler('php://stdout', Logger::INFO);
		$stream->setFormatter(self::getInstance()->getFormatter());
		self::getInstance()->logger->pushHandler($stream); // <<< uses a stream
	}

	protected static function getInstance() : self {
		if (empty(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function info(string $msg, array $params = []) : void {
		self::getInstance()->logger->info(
			vsprintf($msg, $params)
		);
	}

	public static function warn(string $msg, array $params = []) : void {
		self::getInstance()->logger->warning(
			vsprintf($msg, $params)
		);
	}

	public static function error(string $msg, array $params = []) : void {
		self::getInstance()->logger->error(
			vsprintf($msg, $params)
		);
	}

	protected function getFormatter() : LineFormatter {
		return new LineFormatter(self::FORMAT_LOG, self::FORMAT_DATETIME);
	}
}
