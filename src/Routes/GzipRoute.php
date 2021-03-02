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
		$dir_exists = @file_exists($dirName);
		if (!$dir_exists) {
			@mkdir($dirName,0775,true);

		}
		$this->file = gzopen($this->filePath, 'ab9');
		if (!$dir_exists) chmod($this->filePath, 0664);
	}

	/**
	 * @inheritdoc
	 */
	public function __destruct() {
		if ($this->file != null) gzclose($this->file);
		parent::__destruct();
	}

	/**
	 * @inheritdoc
	 */
	public function log($level, $message, array $context = []) {
		gzwrite($this->file,trim(strtr($this->template, [
			'{date}' => date("Y-m-d H:i:s"),
			'{time}' => time(),
			'{ip}' => $this->clientIP(),
			'{level}' => $level,
			'{message}' => $message,
			'{context}' => implode(' || ', $context),
		])) . PHP_EOL);
	}
}
