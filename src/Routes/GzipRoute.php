<?php
namespace AKEB\Logger\Routes;

if (version_compare(PHP_VERSION, '8.0', '<')) {
	class_alias('\AKEB\Logger\Routes\PHP7\GzipRoute_PHP', '\AKEB\Logger\Routes\GzipRoute_PHP');
} else {
	class_alias('\AKEB\Logger\Routes\PHP8\GzipRoute_PHP', '\AKEB\Logger\Routes\GzipRoute_PHP');
}

class GzipRoute extends \AKEB\Logger\Routes\GzipRoute_PHP {

}
