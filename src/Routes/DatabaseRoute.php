<?php
namespace AKEB\Logger\Routes;

use PDO;

/**
 * Class DatabaseRoute
 *
 * Создание таблицы:
 *
 * CREATE TABLE default_log (
 *      id integer PRIMARY KEY,
 *      date date,
 *      time integer,
 *      ip varchar(16),
 *      level varchar(16),
 *      message text,
 *      context text
 * );
 */

if (version_compare(PHP_VERSION, '8.0', '<')) {
	class_alias('\AKEB\Logger\Routes\PHP7\DatabaseRoute_PHP', '\AKEB\Logger\Routes\DatabaseRoute_PHP');
} else {
	class_alias('\AKEB\Logger\Routes\PHP8\DatabaseRoute_PHP', '\AKEB\Logger\Routes\DatabaseRoute_PHP');
}

class DatabaseRoute extends \AKEB\Logger\Routes\DatabaseRoute_PHP {

}
