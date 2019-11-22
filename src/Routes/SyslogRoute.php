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
	public $template = "{date} || {time} || {ip} || {message} || {context}";

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
		$level = $this->resolveLevel($level);
		if ($level === null) return;

		syslog($level, $this->filePath . '| ' . trim(strtr($this->template, [
			'{date}' => $this->getDate(),
			'{time}' => time(),
			'{ip}' => $this->clientIP(),
			'{level}' => $level,
			'{message}' => $message,
			'{context}' => implode(' || ', $context),
		])));
	}

	/**
	 * Преобразование уровня логов в формат подходящий для syslog()
	 *
	 * @see http://php.net/manual/en/function.syslog.php
	 * @param $level
	 * @return string
	 */
	private function resolveLevel($level)
	{
		$map = [
			\Psr\Log\LogLevel::EMERGENCY => LOG_EMERG,
			\Psr\Log\LogLevel::ALERT     => LOG_ALERT,
			\Psr\Log\LogLevel::CRITICAL  => LOG_CRIT,
			\Psr\Log\LogLevel::ERROR     => LOG_ERR,
			\Psr\Log\LogLevel::WARNING   => LOG_WARNING,
			\Psr\Log\LogLevel::NOTICE    => LOG_NOTICE,
			\Psr\Log\LogLevel::INFO      => LOG_INFO,
			\Psr\Log\LogLevel::DEBUG     => LOG_DEBUG,
		];
		return isset($map[$level]) ? $map[$level] : null;
	}
}
