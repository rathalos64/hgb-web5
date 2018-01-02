<?php

class AuthController 
{
	function register() 
	{
		$username = $_POST["username"] ?? null;
		$password = $_POST["password"] ?? null;

		if ($username == null || $password == null) {
			ShoppingList\View::view("welcome", [
				"error" => "Registration: Fields must not be empty",
			]);
		}

		if(!ShoppingList\AuthenticationManager::register($username, $password)) {
			ShoppingList\View::view("welcome", [
				"error" => "Registration: Username already taken",
			]);
		}

		ShoppingList\View::redirect("/");
	}

	function login() 
	{
		$username = $_POST["username"] ?? null;
		$password = $_POST["password"] ?? null;

		if ($username == null || $password == null) {
			ShoppingList\View::view("welcome", [
				"error" => "Login: Fields must not be empty",
			]);
		}

		if (!ShoppingList\AuthenticationManager::attempt($username, $password)) {
			ShoppingList\View::view("welcome", [
				"error" => "Login: Invalid username or password",
			]);
		}

		ShoppingList\View::redirect("/");
	}

	function logout()
	{
		ShoppingList\AuthenticationManager::logout();
		ShoppingList\View::redirect("/");
	}
}