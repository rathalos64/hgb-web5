<?php

namespace App\Controller;

use \App\View;

class IndexController {
	
	function welcome() 
	{
		View::view("welcome");
	}
}