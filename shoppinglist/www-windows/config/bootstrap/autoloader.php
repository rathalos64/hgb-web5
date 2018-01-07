<?php

spl_autoload_register(function ($class) {
    $filename = "C:/xampp/htdocs" . "/app/" . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($filename)) {
        include($filename);
        return true;
    }
    return false;
});