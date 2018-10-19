<?php

namespace Core;


use Core\Traits\Singleton;

class ENV
{
	use Singleton;

	/** @var self */
	protected static $_instance;

	/** @var array */
	private $env;


	/**
	 * @param string $key
	 * @param string $value
	 */
	protected function prepareParameter(string $key, string $value) {
		$value_for_compare = mb_strtolower($value);

		if ($value_for_compare == 'null') {

			$this->env[ $key ] = NULL;

		} elseif (in_array($value_for_compare, [ 'true', 'false' ])) {

			$this->env[ $key ] = $value == 'true';

		} elseif ($value_for_compare === (string) intval($value_for_compare)) {

			$this->env[ $key ] = intval($value);

		} elseif ($value_for_compare === (string) floatval($value_for_compare)) {

			$this->env[ $key ] = floatval($value);

		} elseif (mb_stripos($value, ';') !== false) {

			$this->env[ $key ] = explode(';', $value);

		} else {

			$this->env[ $key ] = $value;

		}
	}


	protected function parseEnvironment() {
		$dot_env = file_get_contents(base_path('.env'));

		$parameters = explode(PHP_EOL, $dot_env);

		foreach ($parameters as $parameter) {
			if (mb_strlen($parameter)) {
				list($key, $value) = explode('=', $parameter);
				$this->prepareParameter($key, $value);
			}
		}
	}


	private function __construct() {
		$this->parseEnvironment();
	}


	/**
	 * @param string     $parameter
	 * @param mixed|null $default
	 *
	 * @return mixed|null
	 */
	public function get(string $parameter, $default = NULL) {
		if (key_exists($parameter, $this->env)) {
			return $this->env[ $parameter ];
		} else {
			return $default;
		}
	}


	/**
	 * @param string $parameter
	 * @param mixed  $value
	 */
	public function set(string $parameter, $value) {
		if (key_exists($parameter, $this->env)) {
			$this->env[ $parameter ] = $value;
		}
	}
}