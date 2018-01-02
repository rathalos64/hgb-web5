<?php

namespace ShoppingList;

class Utils {

	public static function escape(string $string) : string {
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	  }

	// // TODO: better name
	// public static function templateVarMatch(string $template, array $payload) : bool 
	// {
	// 	// retrieve all variable tokens from template
	// 	$tokens = array_filter(token_get_all(file_get_contents($template)), function($token) {
	// 		return $token[0] == T_VARIABLE;
	// 	});

	// 	// filter superglobals and specific vars
	// 	$tokens = array_filter($tokens, function($token) {
	// 		return in_array($token[1], [
	// 			'$GLOBALS',
	// 			'$_SERVER',
	// 			'$_GET',
	// 			'$_POST',
	// 			'$_FILES',
	// 			'$_COOKIE',
	// 			'$_SESSION',
	// 			'$_REQUEST',
	// 			'$_ENV',
	// 			'$key',
	// 			'$value',
	// 			'$payload',
	// 		]) === false;
	// 	});

	// 	// get name of variables; omit "$"
	// 	$variables = array_map(function($token) {
	// 		return substr($token[1], 1);
	// 	}, $tokens);

	// 	// duplicate entries may exist; remove
	// 	$variables = array_unique($variables); sort($variables);
	// 	$keys = array_keys($payload); sort($keys);

	// 	return $variables == $keys;
	// }

	public static function handlePayload($file, $payload) {
		if ($payload == null) {
			throw new \Exception("Invalid access");
		}

		$decoded = base64_decode($payload, true);
		if (!$decoded) {
			throw new \Exception("Invalid access");
		}

		$deserialized = unserialize($decoded);
		if ($deserialized === false) {
			throw new \Exception("Invalid access");
		}

		return $deserialized;
	}

	// TODO: inspect file
	// function getCurrentUri()
	// {
	// 	$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
	// 	$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
	// 	if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
	// 	$uri = '/' . trim($uri, '/');
	// 	return $uri;
	// }
		
	public static function getCurrentRoute() {
		$uri = $_SERVER['REQUEST_URI'];
		
		// delete query part form URI
		if (strstr($uri, '?')) {
			$uri = substr($uri, 0, strpos($uri, '?'));
		}

		// make it route conform
		$uri = '/' . trim($uri, '/');
		return $uri;
	}
}