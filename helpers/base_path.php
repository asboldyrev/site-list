<?php

if (!function_exists('base_path')) {
	/**
	 * @param string $path
	 * @param array  $values
	 */
	function base_path(string $path = NULL) {
		$return = str_replace('/public', '', $_SERVER[ 'DOCUMENT_ROOT' ]);

		if (mb_strlen($path)) {
			$return .= '/' . $path;
		}

		return $return;
	}
}