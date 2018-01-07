<?php

namespace App\Controller;

use \App\View;
use \App\AuthenticationManager;

use \App\Utils;
use \App\Model\Audit;

class AuthController {
	
	function register() 
	{
		$username = $_POST["username"] ?? null;
		$password = $_POST["password"] ?? null;

		if ($username == null || $password == null) {
			View::view("welcome", [
				"error" => "Registration: Fields must not be empty",
			]);
		}

		// -- length constraint --

		if(!AuthenticationManager::register($username, $password)) {
			View::view("welcome", [
				"error" => "Registration: Username already taken",
			]);
		}

		$auditDTO = Audit::buildDTO([
			"username" => $username,
			"action" => Audit::ACTION_REGISTER,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		Audit::create($auditDTO);

		// try to login upon registration
		if (!AuthenticationManager::attempt($username, $password)) {
			View::view("welcome", [
				"error" => "Login: Invalid username or password",
			]);
		}

		$auditDTO = Audit::buildDTO([
			"username" => $username,
			"action" => Audit::ACTION_LOGIN,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		Audit::create($auditDTO);

		View::redirect("/home/dashboard");
	}

	function login() 
	{
		$username = $_POST["username"] ?? null;
		$password = $_POST["password"] ?? null;

		if ($username == null || $password == null) {
			View::view("welcome", [
				"error" => "Login: Fields must not be empty",
			]);
		}

		if (!AuthenticationManager::attempt($username, $password)) {
			View::view("welcome", [
				"error" => "Login: Invalid username or password",
			]);
		}

		$auditDTO = Audit::buildDTO([
			"username" => $username,
			"action" => Audit::ACTION_LOGIN,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		Audit::create($auditDTO);

		View::redirect("/home/dashboard");
	}

	function logout()
	{
		$user = AuthenticationManager::user();
		$auditDTO = Audit::buildDTO([
			"username" => $user->getUsername(),
			"action" => Audit::ACTION_LOGOUT,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		Audit::create($auditDTO);

		AuthenticationManager::logout();
		View::redirect("/");
	}
}