<?php

if (!function_exists('env')) {
	function env(string $parameter = NULL, $default = NULL) {
		if (is_null($parameter)) {
			return $_ENV;
		}

		if(key_exists($parameter, $_ENV)) {
			return $_ENV[ $parameter ];
		}

		return $default;
	}
}