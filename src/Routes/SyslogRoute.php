<?php
namespace AKEB\Logger\Routes;

/**
 * Class SysLog
 */
class SyslogRoute extends \AKEB\Logger\Route {
	/**
	 * @var string Путь к файлу
	 */
	public $filePath;
	/**
	 * @var string ProcessName
	 */
	public $processName;
	/**
	 * @var string Шаблон сообщения
	 */
	public $template = "{date} {level} {message} {context}";

	public $type_hash = [
		'emergency' => LOG_EMERG, // system is unusable
		'alert' => LOG_ALERT, // action must be taken immediately
		'critical' => LOG_CRIT, // critical conditions
		'error' => LOG_ERR, // error conditions
		'warning' => LOG_WARNING, // warning conditions
		'notice' => LOG_NOTICE, // normal, but significant, condition
		'info' => LOG_INFO, // informational message
		'debug' => LOG_DEBUG, // debug-level message
	];

	/**
	 * @inheritdoc
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);
		openlog($this->processName, LOG_PID , LOG_LOCAL7);
	}

	public function __destruct() {
		closelog();
	}

	/**
	 * @inheritdoc
	 */
	public function log($level, $message, array $context = []) {
		syslog($this->type_hash[$level], $this->filePath . '| ' . trim(strtr($this->template, [
			'{date}' => $this->getDate(),
			'{level}' => $level,
			'{message}' => $message,
			'{context}' => implode(' || ', $context),
		])));
	}
}
