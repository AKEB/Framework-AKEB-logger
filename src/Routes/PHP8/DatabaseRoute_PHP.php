<?php
namespace AKEB\Logger\Routes\PHP8;

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

class DatabaseRoute_PHP extends \AKEB\Logger\Route {
	/**
	 * @var string Data Source Name
	 * @see http://php.net/manual/en/pdo.construct.php
	 */
	public $dsn;
	/**
	 * @var string Имя пользователя БД
	 */
	public $username;
	/**
	 * @var string Пароль пользователя БД
	 */
	public $password;
	/**
	 * @var string Имя таблицы
	 */
	public $table;
	/**
	 * @var \PDO Подключение к БД
	 */
	private $connection;

	/**
	 * @inheritdoc
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);
		$this->connection = new PDO($this->dsn, $this->username, $this->password);
	}

	/**
	 * @inheritdoc
	 */
	public function log($level, \Stringable|string $message, array $context = []): void {
		$statement = $this->connection->prepare(
			'INSERT INTO ' . $this->table . ' (date, time, ip, level, message, context) ' .
			'VALUES (:date, :time, :ip, :level, :message, :context)'
		);
		$date = $this->getDate();
		$time = time();
		$ip = $this->clientIP();
		$cnt = $this->contextStringify($context);
		$statement->bindParam(':date',      $date);
		$statement->bindParam(':time',      $time);
		$statement->bindParam(':ip',        $ip);
		$statement->bindParam(':level',     $level);
		$statement->bindParam(':message',   $message);
		$statement->bindParam(':context',   $cnt);
		$statement->execute();
	}
}
