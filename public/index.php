<?php
error_reporting(E_ALL);
ini_set('display_errors', 'true');

require_once '../bootstrap/autoload.php';

$sites = new \Core\SitesList();
$domain = host();
$root_domain = env('ROOT_DOMAIN');

if (mb_strpos($domain, '.' . $root_domain) !== false) {
	$domain = get_domain($domain, 1);
} else {
	$domain = get_domain($domain);
}


include '../views/index.php';