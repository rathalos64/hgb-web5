<?php

class HomeController 
{
	function welcome() 
	{
		ShoppingList\View::view("welcome");
	}
}