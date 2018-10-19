<?php

// Функция автолоада классов
spl_autoload_register(function($class_name) {
	$filename = '../' . str_replace('\\', '/', $class_name) . '.php';

	if (file_exists($filename)) {
		include $filename;
	} else {
		throw new Exception('Не возможно подгрузить ' . $filename);
	}
});

// Подключение файлов с хелперами
if (is_dir('../helpers')) {
	foreach (scandir('../helpers') as $helper) {
		$filename = '../helpers/' . $helper;

		if (is_file($filename)) {
			include_once $filename;
		}
	}
}