<?php

namespace App\Controller;

use \App\View;

class IndexController {
	
	function welcome() 
	{
		if (\App\AuthenticationManager::check()) {
			View::redirect("/home/dashboard");
		}
		
		View::view("welcome");
	}
}