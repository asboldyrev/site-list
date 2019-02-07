<?php

if (!function_exists('get_domain')) {
	function get_domain(string $host, int $level = 2, $ignoreWWW = false) {
		$parts = explode('.', $host);

		if ($ignoreWWW and $parts[ 0 ] == 'www') {
			unset($parts[ 0 ]);
		}

		$parts = array_slice($parts, -$level);

		return implode('.', $parts);
	}
}