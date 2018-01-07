<?php

namespace App\Controller;

use \App\View;
use \App\AuthenticationManager;
use \App\Utils;

use \App\Model\Audit;
use \App\Model\Liste;
use \App\Model\Article;

class ArticleController {

	function getAdd() 
	{
		$listId = intval($_GET["listId"]) ?? null;
		if ($listId == null) {
			View::redirect("/home/dashboard");	
		}

		View::view("home.article.add", [
			"listId" => $listId
		]);
	}

	function postAdd()
	{
		$listId = intval($_POST["listId"]) ?? null;
		if ($listId == null) {
			View::view("home.article.add", [
				"listId" => $listId,
				"error" => "Adding article: Invalid list"
			]);
		}

		$title = $_POST["title"] ?? null;
		if ($title == null) {
			View::view("home.article.add", [
				"listId" => $listId,
				"error" => "Adding article: Title must not be empty"
			]);
		}

		$description = $_POST["description"] ?? null;
		if ($description == null) {
			View::view("home.article.add", [
				"listId" => $listId,
				"error" => "Adding article: Description must not be empty"
			]);
		}

		// -- length constraint --

		$user = AuthenticationManager::user();
		try {
			$liste = Liste::getById($listId, $user->getId());
		} catch (\Exception $e) {
			View::view("home.article.add", [
				"listId" => $listId,
				"error" => $e->getMessage()
			]);
		}
		if ($liste == null) {
			View::view("home.article.add", [
				"listId" => $listId,
				"error" => "Adding article: Invalid list"
			]);
		}
		
		// -- create --
		$articleDTO = Article::buildDTO([
			"listId" => $listId,
			"title" => $title,
			"description" => $description,
			"state" => Article::STATE_UNFINISHED
		]);
		try {
			Article::create($articleDTO);
		} catch (\Exception $e) {
			$error = $e->getMessage();
			View::view("home.article.add", [
				"listId" => $listId,
				"error" => $error
			]);
		}

		// -- update list --
		$listDTO = Liste::buildUpdateDTO([
			"state" => Liste::STATE_LEFT_ARTICLES,
			"numberOfArticles" => ($liste->getNumberOfArticles() + 1)
		]);
		try {
			Liste::updateById($listId, $user->getId(), $listDTO);
		} catch (\Exception $e) {
			$error = $e->getMessage();
			View::view("home.article.add", [
				"listId" => $listId,
				"error" => $error
			]);
		}

		// -- audit --
		$auditDTO = Audit::buildDTO([
			"username" => $user->getUsername(),
			"action" => Audit::ACTION_ADD_ARTICLE,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		try {
			Audit::create($auditDTO);
		} catch (\Exception $e) {
			$error = $e->getMessage();
			View::view("home.article.add", [
				"listId" => $listId,
				"error" => $error
			]);
		}

		View::redirect("/home/list/edit?listId={$listId}");
	}

	function delete()
	{
		$listId = $_GET["listId"] ?? null;
		if ($listId == null) {
			View::redirect("/home/dashboard");
		}

		$articleId = $_GET["articleId"] ?? null;
		if ($articleId == null) {
			View::redirect("/home/list/edit?listId={$listId}");
		}

		$user = AuthenticationManager::user();
		try {
			$liste = Liste::getById($listId, $user->getId());
		} catch (\Exception $e) {
			View::redirect("/home/list/edit?listId={$listId}");
		}

		// -- delete --
		try {
			$article = Article::getById($articleId, $listId);
		} catch (\Exception $e) {
			View::redirect("/home/list/edit?listId={$listId}");
		}
		Article::deleteById($articleId, $listId);

		// -- update list --
		$state = $liste->getState();
		$numberOfArticles = $liste->getNumberOfArticles() - 1;
		$finishedArticles = $liste->getFinishedArticles();
		if ($article->getState() == Article::STATE_FINISHED) {
			$finishedArticles -= 1;
		}

		if ($numberOfArticles == $finishedArticles) {
			$state = Liste::STATE_FINISHED;
		}

		if ($numberOfArticles == 0) {
			$state = Liste::STATE_NO_ARTICLES;
		}

		$listDTO = Liste::buildUpdateDTO([
			"state" => $state,
			"numberOfArticles" => $numberOfArticles,
			"finishedArticles" => $finishedArticles
		]);
		Liste::updateById($listId, $user->getId(), $listDTO);

		// -- audit --
		$auditDTO = Audit::buildDTO([
			"username" => $user->getUsername(),
			"action" => Audit::ACTION_DELETE_ARTICLE,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		Audit::create($auditDTO);
		
		View::redirect("/home/list/edit?listId={$listId}");
	}

	function finish()
	{
		$listId = $_GET["listId"] ?? null;
		if ($listId == null) {
			View::redirect("/home/dashboard");
		}

		$articleId = $_GET["articleId"] ?? null;
		if ($articleId == null) {
			View::redirect("/home/list/edit?listId={$listId}");
		}

		$user = AuthenticationManager::user();
		try {
			$liste = Liste::getById($listId, $user->getId());
		} catch (\Exception $e) {
			View::redirect("/home/list/edit?listId={$listId}");
		}

		// -- delete --
		try {
			Article::getById($articleId, $listId);
		} catch (\Exception $e) {
			View::redirect("/home/list/edit?listId={$listId}");
		}
		
		// -- update list --
		$articleDTO = Article::buildUpdateDTO([
			"state" => Article::STATE_FINISHED
		]);
		Article::updateById($articleId, $listId, $articleDTO);

		// -- update list --
		$listDTO = Liste::buildUpdateDTO([
			"state" => $liste->getNumberOfArticles() == ($liste->getFinishedArticles() + 1) ? Liste::STATE_FINISHED : Liste::STATE_LEFT_ARTICLES,
			"finishedArticles" => ($liste->getFinishedArticles() + 1)
		]);
		Liste::updateById($listId, $user->getId(), $listDTO);

		// -- audit --
		$auditDTO = Audit::buildDTO([
			"username" => $user->getUsername(),
			"action" => Audit::ACTION_FINISH_ARTICLE,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		Audit::create($auditDTO);
		
		View::redirect("/home/list/edit?listId={$listId}");
	}

	function unfinish()
	{
		$listId = $_GET["listId"] ?? null;
		if ($listId == null) {
			View::redirect("/home/dashboard");
		}

		$articleId = $_GET["articleId"] ?? null;
		if ($articleId == null) {
			View::redirect("/home/list/edit?listId={$listId}");
		}

		$user = AuthenticationManager::user();
		try {
			$liste = Liste::getById($listId, $user->getId());
		} catch (\Exception $e) {
			View::redirect("/home/list/edit?listId={$listId}");
		}

		// -- delete --
		try {
			Article::getById($articleId, $listId);
		} catch (\Exception $e) {
			View::redirect("/home/list/edit?listId={$listId}");
		}
		
		// -- update list --
		$articleDTO = Article::buildUpdateDTO([
			"state" => Article::STATE_UNFINISHED
		]);
		Article::updateById($articleId, $listId, $articleDTO);

		// -- update list --
		$listDTO = Liste::buildUpdateDTO([
			"state" => Liste::STATE_LEFT_ARTICLES,
			"finishedArticles" => ($liste->getFinishedArticles() - 1)
		]);
		Liste::updateById($listId, $user->getId(), $listDTO);

		// -- audit --
		$auditDTO = Audit::buildDTO([
			"username" => $user->getUsername(),
			"action" => Audit::ACTION_UNFINISH_ARTICLE,
			"ip" => Utils::getClientIp(),
			"userAgent" => Utils::getUserAgent(),
			"created_at" => time()
		]);
		Audit::create($auditDTO);
		
		View::redirect("/home/list/edit?listId={$listId}");
	}
}