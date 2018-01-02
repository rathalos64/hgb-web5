<?php

namespace ShoppingList;

class Config {

	const ENV = [
		"PROJECT_ROOT",
		"MYSQL_HOST",
		"MYSQL_DB",
		"MYSQL_USER",
		"MYSQL_PASSWORD"
	];

	public static function check() : bool {
		foreach (self::ENV as $env) {
			if (getenv($env) === false) {
				return false;
			}
		}

		return true;
	}

	public static function get(string $env) : string {
		$env = strtoupper($env);
		if (in_array($env, self::ENV) === false) {
			throw new \Exception("Environmental variable not found");
		}

		return getenv($env);
	}
}