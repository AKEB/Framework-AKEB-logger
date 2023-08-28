<?php
namespace AKEB\Logger\PHP7;

use Psr\Log\AbstractLogger;
use SplObjectStorage;

/**
 * Class Logger_PHP
 */
class Logger_PHP extends AbstractLogger {
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
	public function log($level, $message, array $context = []): void {
		foreach ($this->routes as $route) {
			if (!$route instanceof \AKEB\Logger\Route) {
				continue;
			}
			if (!$route->isEnable) {
				continue;
			}
			$route->log($level, $message, $context);
		}
	}
}

