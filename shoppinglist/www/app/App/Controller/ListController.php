<?php

namespace App\Controller;

use \App\View;
use \App\AuthenticationManager;

class ListController {

	const PAGINATION = 10;

	function get()
	{
		$userId = AuthenticationManager::id();
		$error = null;

		$lists = [];
		try {
			$lists = \App\Model\Liste::getAll($userId);
			if ($lists == null) {
				$lists = [];
			}
		} catch (\Exception $e) {
			$error = $e->getMessage();
		}

		View::view("home.list.all", [
			"lists" => $lists,
			"error" => $error,
		]);
	}

	function getAdd() 
	{
		View::view("home.list.add");
	}

	function postAdd()
	{
		$title = $_POST["title"] ?? null;
		if ($title == null) {
			View::view("home.list.add", [
				"error" => "Adding list: Title must not be empty"
			]);
		}		

		$userId = AuthenticationManager::id();
		
		$listDTO = \App\Model\Liste::buildDTO([
			"userId" => $userId,
			"title" => $title,
			"description" => "",
			"state" => \App\Model\Liste::STATE_NO_ARTICLES,
			"numberOfArticles" => 0,
			"unfinishedArticles" => -1
		]);

		try {
			\App\Model\Liste::create($listDTO);
		} catch (\Exception $e) {
			$error = $e->getMessage();
			View::view("home.list.add", [
				"error" => $error
			]);
		}

		View::redirect("/home/dashboard");
	}
}