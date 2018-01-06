<?php

namespace App;

SessionContext::create();
class AuthenticationManager {

	public static function attempt(string $username, string $password) : bool {
		$user = Model\User::getByUsername($username);
		if ($user === null) {
			return false;
		}

		if (!password_verify($password, $user->getPassword())) {
			return false;
		}

		$_SESSION["user"] = $user->getId();
		return true;
	}

	public static function register(string $username, string $password) {
		$user = Model\User::getByUsername($username);
		if ($user != null) {
			return false;
		}

		$dto = Model\User::buildDTO([
			"username" => $username, 
			"password" => password_hash($password, PASSWORD_BCRYPT)
		]);
		Model\User::create($dto);
		return true;
	}

	public static function logout() {
		unset($_SESSION['user']);
	}

	public static function check() : bool {
		return isset($_SESSION['user']);
	}

	public static function user()  {
		return self::check() ? Model\User::getById($_SESSION['user']) : null;
	}

	public static function id() {
		$user = self::user();
		if ($user == null) {
			return null;
		}

		return $user->getId();
	}
}