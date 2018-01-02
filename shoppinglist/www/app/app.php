<?php

spl_autoload_register(function ($class) {
    $filename = __DIR__ . '/controller/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($filename)) {
		include($filename);
		return true;
	}
	return false;
});

spl_autoload_register(function ($class) {
    $filename = __DIR__ . '/model/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($filename)) {
		include($filename);
		return true;
	}
	return false;
});