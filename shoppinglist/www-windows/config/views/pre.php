<?php
require_once("C:/xampp/htdocs" . "/config/bootstrap.php");

$payload = App\Utils::handlePayload(__FILE__, $_GET["payload"] ?? null); 

// create all variables based on given payload
foreach ($payload as $key => $value) {
	${$key} = $value;
}

function e(string $string) : string {
	return App\Utils::escape($string);
}

$user = App\AuthenticationManager::user();