<?php

namespace App\Controller;

use \App\View;
use \App\AuthenticationManager;

class HomeController {

	function dashboard() 
	{
		$user = AuthenticationManager::user();

		View::view("home.dashboard", [
			"user" => $user
		]);
	}
}