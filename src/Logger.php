<?php

namespace AKEB\Logger;

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

if (version_compare(PHP_VERSION, '8.0', '<')) {
	class_alias('\AKEB\Logger\PHP7\Logger_PHP', '\AKEB\Logger\Logger_PHP');
} else {
	class_alias('\AKEB\Logger\PHP8\Logger_PHP', '\AKEB\Logger\Logger_PHP');
}

class Logger extends \AKEB\Logger\Logger_PHP {

}