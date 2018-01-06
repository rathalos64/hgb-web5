<?php

namespace App\Controller;

use \App\View;
use \App\AuthenticationManager;

class HomeController {

	const PAGINATION = 10;

	function dashboard() 
	{
		View::view("home.dashboard");
	}

	function audit()
	{
		$user =  AuthenticationManager::user();
		$error = null;

		$page = $_GET["page"] ?? 1;
		$page = intval($page);

		$audits = [];
		try {
			$audits = \App\Model\Audit::getAll($user->getUsername());
			if ($audits == null) {
				$audits = [];
			}
		} catch (\Exception $e) {
			$error = $e->getMessage();
		}

		$pages = ceil(count($audits) / HomeController::PAGINATION);
		$paginated = array_splice($audits, ($page - 1) * HomeController::PAGINATION, $page * HomeController::PAGINATION);

		View::view("home.audit", [
			"audits" => $paginated,
			"page" 	=> $page,
			"pages" => $pages,
			"error" => $error,
		]);
	}
}