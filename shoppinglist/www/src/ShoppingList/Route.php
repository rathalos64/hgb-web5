<?php

namespace ShoppingList;

class Route {
	public static $routes = [];

	public static function get(string $route, string $handler) {
		$request_method = "GET";
		self::$routes[$route][$request_method] = $handler;
	}

	public static function post(string $route, string $handler) {
		$request_method = "POST";
		self::$routes[$route][$request_method] = $handler;
	}

	public static function resolve(string $route, string $request_method) : array {
		if (in_array($route, array_keys(self::$routes)) === false) {
			throw new \Exception("404: Could not find route");
		}

		if (in_array($request_method, array_keys(self::$routes[$route])) === false) {
			throw new \Exception("405: Path does not define this method");
		}

		$handler = self::$routes[$route][$request_method];
		if (substr_count($handler, "@") != 1) {
			throw new \Exception("Invalid handler defined. Must contain only one '@'");
		}

		list($class, $method) = explode("@", $handler);
		if (!class_exists($class)) {
			throw new \Exception("Could not find Controller: {$class}");
		}

		if (!method_exists(new $class(), $method)) {
			throw new \Exception("Could not find Controller handler: {$method}");
		}

		return explode("@", $handler);
	}
}