<?php

if (!function_exists('get_root_domain')) {
	function get_root_domain() {
		if (file_exists('/etc/dnsmasq.conf')) {
			$pattern = '/^address=\/([\w]*)\/127\.0\.0\.1/m';
			$conf = file_get_contents('/etc/dnsmasq.conf');
			preg_match_all($pattern, $conf, $matches);
			return $matches[ 1 ][ 0 ];
		}

		return env('DEFAULT_ROOT_DOMAIN', 'loc');
	}
}