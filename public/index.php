<?php

use Dotenv\Dotenv;
use Sites\SiteList;

require_once '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if(env('DEBUG')) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'true');
}

$list = new SiteList();

if(key_exists('sort', $_GET) && $_GET['sort'] == 'update') {
	$list->sort('lastUpdate', 'desc');
	$sort = 'update';
} else {
	$list->sort('name');
	$sort = 'name';
}


include '../src/template.php';