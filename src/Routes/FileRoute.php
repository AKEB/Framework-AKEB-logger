<?php
namespace AKEB\Logger\Routes;

/**
 * Class FileRoute
 */
class FileRoute extends \AKEB\Logger\Route {
	/**
	 * @var string Путь к файлу
	 */
	public $filePath;
	/**
	 * @var string Шаблон сообщения
	 */
	public $template = "{date} {level} {message} {context}";

	/**
	 * @inheritdoc
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);

		$dirName = dirname($this->filePath);
		$have_file = @file_exists($this->filePath);
		if (!$have_file) {
			@mkdir($dirName,0775,true);
			touch($this->filePath);
		}
	}

	private function clientIP() {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$remote_addrs = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
			$remote_addr = trim(end($remote_addrs));
		} elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$remote_addr = trim($_SERVER['REMOTE_ADDR']);
		} else {
			$remote_addr = '';
		}
		if (!$remote_addr) $remote_addr = 'undefined';
		return $remote_addr;
	}

	/**
	 * @inheritdoc
	 */
	public function log($level, $message, array $context = []) {
		file_put_contents($this->filePath, trim(strtr($this->template, [
			'{date}' => $this->getDate(),
			'{time}' => time(),
			'{ip}' => $this->clientIP(),
			'{level}' => $level,
			'{message}' => $message,
			'{context}' => implode(' || ', $context),
		])) . PHP_EOL, FILE_APPEND);
	}
}
