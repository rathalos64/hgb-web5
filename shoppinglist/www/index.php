<?php
require_once("config/bootstrap.php");
require_once("routes/web.php");
require_once("app/app.php");

if (ShoppingList\Config::check() == false) {
	throw new Exception("Not all expected environmental variables set");
}

$route = ShoppingList\Utils::getCurrentRoute();
$request_method = $_SERVER["REQUEST_METHOD"]; 

list($class, $method) = ShoppingList\Route::resolve($route, $request_method);
(new $class())->$method();