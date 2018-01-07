<?php

namespace App\Controller;

use \App\View;
use \App\AuthenticationManager;
use \App\Utils;

use \App\Model\Audit;
use \App\Model\Liste;
use \App\Model\Article;

class ListController {

	const PAGINATION = 4;
	const COLUMNS = 2;

	const PAGINATION_ARTICLE = 5;

	function get()
	{
		$userId = AuthenticationManager::id();
		$error = null;

		$page = $_GET["page"] ?? 1;
		$page = intval($page);

		$lists = [];
		try {
			$lists = Liste::getAll($userId);
			if ($lists == null) {
				$lists = [];
			}
		} catch (\Exception $e) {
			$error = $e->getMessage();
		}

		$pages = ceil(count($lists) / ListController::PAGINATION);	
		$paginated = array_slice($lists, ($page - 1) * ListController::PAGINATION, ListController::PAGINATION);
		
		$listRows = ceil(count($paginated) / ListController::COLUMNS);

		View::view("home.list.all", [
			"lists" => $paginated,
			"listRows" => $listRows,
			"pages" => $pages,
			"page" => $page,
			"error" => $error,
		]);
	}

	function edit()
	{
		$error = $_GET["error"] ?? null;
		$user = AuthenticationManager::user();

		$listId = intval($_GET["listId"]) ?? null;
		if ($listId == null) {
			View::redirect("/home/list");
		}

		try {
			$liste = Liste::getById($listId, $user->getId());
		} catch (\Exception $e) {
			View::redirect("/home/list");
		}

		$articles = [];
		try {
			$articles = Article::getAll($listId);
			if ($articles == null) {
				$articles = [];
			}
		} catch (\Exception $e) {
			View::redirect("/home/list");
		}

		$page = $_GET["page"] ?? 1;
		$page = intval($page);

		$pages = ceil(count($articles) / ListController::PAGINATION_ARTICLE);	
		$paginated = array_splice($articles, ($page - 1) * ListController::PAGINATION_ARTICLE, ListController::PAGINATION_ARTICLE);

		View::view("home.list.list", [
			"list" => $liste,
			"listId" => $listId,
			"articles" => $paginated,
			"pages" => $pages,
			"page" => $page,
			"error" => $error
		]);
	}

	function postEdit()
	{
		$listId = $_POST["listId"] ?? null;
		if ($listId == null) {
			View::redirect("/home/list");
		}
		
		$title = $_POST["title"] ?? null;
		if ($title == null) {
			View::redirect("/home/list/edit?listId={$listId}&error=" . urlencode("Edit list: Title must not be empty"));
		}

		$description = $_POST["description"] ?? null;
		if ($title == null) {
			View::redirect("/home/list/edit?listId={$listId}&error=" . urlencode("Edit list: Description must not be empty"));
		}

		// -- length constraint --

		$user = AuthenticationManager::user();

		// -- update list --
		$listDTO = Liste::buildUpdateDTO([
			"title" => $title,
			"description" => $description
		]);
		try {
			Liste::updateById($listId, $user->getId(), $listDTO);
		} catch (\Exception $e) {
			View::redirect("/home/list/edit?listId={$listId}&error=" . urlencode($e->getMessage()));
		}
		
		$auditDTO = Audit::buildDTO([
			"username" => $user->getUsername(),
			"action" => Audit::ACTION_EDIT_LIST,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		try {
			Audit::create($auditDTO);
		} catch (\Exception $e) {
			View::redirect("/home/list/edit?listId={$listId}&error=" . urlencode($e->getMessage()));
		}

		View::redirect("/home/list/edit?listId={$listId}");
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

		// -- length constraint --

		$user = AuthenticationManager::user();
		
		$listDTO = Liste::buildDTO([
			"userId" => $user->getId(),
			"title" => $title,
			"description" => "",
			"state" => Liste::STATE_NO_ARTICLES,
			"numberOfArticles" => 0,
			"finishedArticles" => 0
		]);
		try {
			Liste::create($listDTO);
		} catch (\Exception $e) {
			$error = $e->getMessage();
			View::view("home.list.add", [
				"error" => $error
			]);
		}

		$auditDTO = Audit::buildDTO([
			"username" => $user->getUsername(),
			"action" => Audit::ACTION_ADD_LIST,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		try {
			Audit::create($auditDTO);
		} catch (\Exception $e) {
			$error = $e->getMessage();
			View::view("home.list.add", [
				"error" => $error
			]);
		}

		View::redirect("/home/list");
	}

	function delete()
	{
		$listId = $_GET["listId"] ?? null;
		if ($listId == null) {
			View::redirect("/home/list");
		}

		$user = AuthenticationManager::user();

		try {
			Liste::getById($listId, $user->getId());
		} catch (\Exception $e) {
			View::redirect("/home/list");
		}
		Liste::deleteById($listId, $user->getId());

		$auditDTO = Audit::buildDTO([
			"username" => $user->getUsername(),
			"action" => Audit::ACTION_DELETE_LIST,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		Audit::create($auditDTO);
		
		View::redirect("/home/list");
	}
}