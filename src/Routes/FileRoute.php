<?php
namespace AKEB\Logger\Routes;

if (version_compare(PHP_VERSION, '8.0', '<')) {
	class_alias('\AKEB\Logger\Routes\PHP7\FileRoute_PHP', '\AKEB\Logger\Routes\FileRoute_PHP');
} else {
	class_alias('\AKEB\Logger\Routes\PHP8\FileRoute_PHP', '\AKEB\Logger\Routes\FileRoute_PHP');
}

class FileRoute extends \AKEB\Logger\Routes\FileRoute_PHP {

}