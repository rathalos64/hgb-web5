<?php

namespace ShoppingList;

class View {

	const ROOT = "views";

	// TODO: save template paths in envs
	public static function view(string $template, array $payload = []) 
	{
		$template = str_replace(".", "/", $template);
		$template = self::ROOT . "/{$template}.php";
		
		if (!file_exists($template)) {
			throw new \Exception("View {$template} does not exist");
		}

		// verify that all fields in payload match
		// the needed data in $template
		// if (!Utils::templateVarMatch($template, $payload)) {
		// 	throw new \Exception("Missing data for {$template}");
		// }

		// encode payload
		$q = urlencode(base64_encode(serialize($payload)));

		// TODO: url concat function
		// append encoded payload as GET parameter
		$url = $_SERVER["HTTP_HOST"] . "/{$template}?payload={$q}";

		$scheme = "http";
		if (isset($_SERVER["HTTPS"])) {
			$scheme = "https";
		}

		// redirect
		header("Location: {$scheme}://{$url}");
		exit();
	}

	public static function redirect(string $path) 
	{
		header("Location: $path");
		exit();
	}
}