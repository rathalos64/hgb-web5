<?php

namespace App;

class Config {

	const DEFAULT = false;

	const ENV = [
		"PROJECT_ROOT",
		"MYSQL_HOST",
		"MYSQL_DB",
		"MYSQL_USER",
		"MYSQL_PASSWORD"
	];

	const ENV_DEFAULT = [
		"PROJECT_ROOT" => "/var/www/html",
		"MYSQL_HOST" => "localhost",
		"MYSQL_DB" => "fh_shoppinglist",
		"MYSQL_USER" => "fh_root",
		"MYSQL_PASSWORD" => "toor_hf"
	];

	public static function check($default = false) : bool {
		if (self::DEFAULT) {
			return true;
		}

		foreach (self::ENV as $env) {
			if (getenv($env) === false) {
				return false;
			}
		}

		return true;
	}

	public static function get(string $env) : string {
		$env = strtoupper($env);
		if (self::DEFAULT) {
			return self::ENV_DEFAULT[$env];
		}

		if (in_array($env, self::ENV) === false) {
			throw new \Exception("Environmental variable not found");
		}

		return getenv($env);
	}
}