<?php
namespace AKEB\Logger\Routes;

if (version_compare(PHP_VERSION, '8.0', '<')) {
	class_alias('\AKEB\Logger\Routes\PHP7\SyslogRoute_PHP', '\AKEB\Logger\Routes\SyslogRoute_PHP');
} else {
	class_alias('\AKEB\Logger\Routes\PHP8\SyslogRoute_PHP', '\AKEB\Logger\Routes\SyslogRoute_PHP');
}

class SyslogRoute extends \AKEB\Logger\Routes\SyslogRoute_PHP {

}
