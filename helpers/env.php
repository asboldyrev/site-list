<?php

if (!function_exists('env')) {
	/**
	 * @param string|NULL $parameter
	 * @param mixed|null  $default
	 *
	 * @return mixed|null|\Core\ENV
	 */
	function env(string $parameter = NULL, $default = NULL) {
		$env = \Core\ENV::getInstance();

		if (is_null($parameter)) {
			return $env;
		}

		return $env->get($parameter, $default);
	}
}