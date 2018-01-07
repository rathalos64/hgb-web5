<?php
require_once("config/bootstrap.php");
require_once("routes/web.php");

if (App\Config::check() == false) {
	throw new Exception("Not all expected environmental variables set");
}

$route = App\Utils::getCurrentRoute();
$request_method = $_SERVER["REQUEST_METHOD"]; 

list($class, $method) = App\Route::resolve($route, $request_method);
(new $class())->$method();