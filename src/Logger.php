<?php
namespace AKEB\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use SplObjectStorage;

/*
	$logger = new \AKEB\Logger\Logger();

	$logger->routes->attach(new \AKEB\Logger\Routes\FileRoute([
		'isEnable' => true,
		'filePath' => '_2.log',
	]));

	$logger->info("Info message");
	$logger->alert("Alert message");
	$logger->error("Error message");
	$logger->debug("Debug message");
	$logger->notice("Notice message");
	$logger->warning("Warning message");
	$logger->critical("Critical message");
	$logger->emergency("Emergency message");
 */

/**
 * Class Logger
 */
class Logger extends AbstractLogger implements LoggerInterface {
	/**
	 * @var SplObjectStorage Список роутов
	 */
	public $routes;

	/**
	 * Конструктор
	 */
	public function __construct() {
		$this->routes = new SplObjectStorage();
	}

	/**
	 * @inheritdoc
	 */
	public function log($level, $message, array $context = []) {
		foreach ($this->routes as $route) {
			if (!$route instanceof Route) {
				continue;
			}
			if (!$route->isEnable) {
				continue;
			}
			$route->log($level, $message, $context);
		}
	}
}