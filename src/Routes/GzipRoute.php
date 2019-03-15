<?php
namespace AKEB\Logger\Routes;

/**
 * Class GzipRoute
 */
class GzipRoute extends \AKEB\Logger\Route {
	/**
	 * @var string Путь к файлу
	 */
	public $filePath;
	/**
	 * @var string Шаблон сообщения
	 */
	public $template = "{date} || {time} || {ip} || {message} || {context}";

	private $file;

	/**
	 * @inheritdoc
	 */
	public function __construct(array $attributes = []) {
		parent::__construct($attributes);

		$dirName = dirname($this->filePath);
		$have_file = @file_exists($this->filePath);
		if (!$have_file) {
			@mkdir($dirName,0775,true);

		}
		$this->file = gzopen($this->filePath, 'ab9');
		if (!$have_file) chmod($this->filePath, 0664);
	}

	/**
	 * @inheritdoc
	 */
	public function __destruct() {
		if ($this->file != null) gzclose($this->file);
		parent::__destruct();
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
		gzwrite($this->file,trim(strtr($this->template, [
			'{date}' => date("Y-m-d H:i:s"),
			'{time}' => time(),
			'{ip}' => $this->clientIP(),
			'{message}' => $message,
			'{context}' => implode(' || ', $context),
		])) . PHP_EOL);
	}
}
