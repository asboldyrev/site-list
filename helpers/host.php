<?php

if (!function_exists('host')) {
	function host() {
		return $_SERVER[ 'HTTP_HOST' ];
	}
}