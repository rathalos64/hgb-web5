<?php

namespace App\Controller;

use \App\View;
use \App\AuthenticationManager;

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

		if(!AuthenticationManager::register($username, $password)) {
			View::view("welcome", [
				"error" => "Registration: Username already taken",
			]);
		}

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

		View::redirect("/home/dashboard");
	}

	function logout()
	{
		AuthenticationManager::logout();
		View::redirect("/");
	}
}