<?php

namespace App;

class Utils {

	public static function escape(string $string) : string 
	{
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}

	public static function handlePayload($file, $payload) 
	{
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
		
	public static function getCurrentRoute() 
	{
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