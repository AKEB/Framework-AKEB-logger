<?php
namespace AKEB\Logger;

use DateTime;
use Psr\Log\AbstractLogger;

/**
 * Class Route
 */
abstract class Route extends AbstractLogger {
	/**
	 * @var bool Включен ли роут
	 */
	public $isEnable = true;
	/**
	 * @var string Формат даты логов
	 */
	public $dateFormat = DateTime::RFC2822;

	/**
	 * Конструктор
	 *
	 * @param array $attributes Атрибуты роута
	 */
	public function __construct(array $attributes = []) {
		foreach ($attributes as $attribute => $value) {
			if (property_exists($this, $attribute)) {
				$this->{$attribute} = $value;
			}
		}
	}

	public function __destruct() {

	}

	/**
	 * Текущая дата
	 *
	 * @return string
	 */
	public function getDate() {
		return (new DateTime())->format($this->dateFormat);
	}

	public function clientIP() {
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
	 * Преобразование $context в строку
	 *
	 * @param array $context
	 * @return string
	 */
	public function contextStringify(array $context = []) {
		return !empty($context) ? json_encode($context) : null;
	}
}