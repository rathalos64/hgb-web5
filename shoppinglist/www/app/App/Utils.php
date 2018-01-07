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

	public static function getClientIp() : string
	{
		if (getenv("HTTP_CLIENT_IP")) {
			return getenv("HTTP_CLIENT_IP");
		} 
		
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			return getenv("HTTP_X_FORWARDED_FOR");
		}

		if(getenv("HTTP_X_FORWARDED")) {
			return getenv("HTTP_X_FORWARDED");
		}

		if(getenv("HTTP_FORWARDED_FOR")) {
			return getenv("HTTP_FORWARDED_FOR");
		}

		if(getenv("HTTP_FORWARDED")) {
		   return getenv("HTTP_FORWARDED");
		}

		if(getenv("REMOTE_ADDR")) {
			return getenv("REMOTE_ADDR");
		}

		return "UNKNOWN";
	}

	public static function getUserAgent() : string
	{
		if (getenv("HTTP_USER_AGENT")) {
			return getenv("HTTP_USER_AGENT");
		}

		return "UNKNOWN";
	}

	public static function getBrowser(string $userAgent) : string 
	{
		if (strpos($userAgent, "Opera") || strpos($userAgent, "OPR/")) { return "Opera"; }
		if (strpos($userAgent, "Edge")) { return "Edge"; }
		if (strpos($userAgent, "Chrome")) { return "Chrome"; }
		if (strpos($userAgent, "Safari")) { return "Safari"; }
		if (strpos($userAgent, "Firefox")) { return "Firefox"; }
		if (strpos($userAgent, "MSIE") || strpos($userAgent, "Trident/7")) { return "Internet Explorer"; }
	   
		return "UNKNOWN";
	}

	public static function listStateToDisplay(int $state) : string
	{
		if ($state == Model\Liste::STATE_FINISHED) {
			return "No articles left. Everything is bought";
		}

		if ($state == Model\Liste::STATE_LEFT_ARTICLES) {
			return "unprocessed articles left";
		}

		if ($state == Model\Liste::STATE_NO_ARTICLES) {
			return "No articles yet. Empty list";
		}

		return "UNKNOWN";
	}

	public static function listStateToDisplayShort(int $state) : string
	{
		if ($state == Model\Liste::STATE_FINISHED) {
			return "Finished";
		}

		if ($state == Model\Liste::STATE_LEFT_ARTICLES) {
			return "Unfinished";
		}

		if ($state == Model\Liste::STATE_NO_ARTICLES) {
			return "Empty";
		}

		return "UNKNOWN";
	}

	public static function listStateToColor(int $state) : string
	{
		if ($state == Model\Liste::STATE_FINISHED) {
			return "success";
		}

		if ($state == Model\Liste::STATE_LEFT_ARTICLES) {
			return "warning";
		}

		if ($state == Model\Liste::STATE_NO_ARTICLES) {
			return "light";
		}

		return "UNKNOWN";
	}
}