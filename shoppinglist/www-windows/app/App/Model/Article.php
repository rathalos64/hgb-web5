<?php

namespace App\Model;

class Article extends Entity {

  const STATE_FINISHED = 1;
  const STATE_UNFINISHED = 2;

  private $listId;
  private $title;
  private $description;
  private $state;

  public function __construct(int $id, int $listId, string $title, string $description, int $state) {
    parent::__construct($id);
    $this->listId = $listId;
    $this->title = $title;
    $this->description = $description;
    $this->state = $state;
  }

  public function getListId() : int {
    return $this->listId;
  }

  public function getTitle() : string {
    return $this->title;
  }

  public function getDescription() : string {
    return $this->description;
  }

  public function getState() : int {
    return $this->state;
  }

  public static function buildBO($obj) {
	  return new Article(
      $obj->id,
      $obj->listId,
		  $obj->title,
      $obj->description,
      $obj->state
	  );
  }

  public static function buildDTO($obj) {
    return new Article(
      -1,
      $obj["listId"],
      $obj["title"],
      $obj["description"],
      $obj["state"]
    );
  }

  public static function buildUpdateDTO($obj) 
  {
    return new Article(
      -1,
      $obj["listId"] ?? -1,
      $obj["title"] ?? "",
      $obj["description"] ?? "",
      $obj["state"] ?? -1
    );
  }

  public static function create(Article $article) : int 
  {
    $query = "INSERT INTO article (listId, title, description, state) VALUES (?, ?, ?, ?);";
    return \App\DataManager::create($query, [
      $article->listId,
      $article->title,
      $article->description,
      $article->state
    ]);
  }

  public static function getAll(int $listId)
  {
    $query = "SELECT id, listId, title, description, state FROM article WHERE listId = ? ORDER BY state DESC";
    return \App\DataManager::get($query, [$listId], "\App\Model\Article");
  }

  public static function getById(int $id, int $listId)
  {
    $query = "SELECT id, listId, title, description, state FROM article WHERE id = ? AND listId = ?";
    $lists = \App\DataManager::get($query, [$id, $listId], "\App\Model\Article");
    if (count($lists) > 0) {
      return $lists[0];
    }
    return null;
  }

  public static function updateById(int $id, int $listId, Article $article) : int
  {
    $params = [];
    $query_parts = [];

    if ($article->getTitle() != "") {
      array_push($params, $article->getTitle());
      array_push($query_parts, "title = ?");
    }

    if ($article->getDescription() != "") {
      array_push($params, $article->getDescription());
      array_push($query_parts, "description = ?");
    }

    if ($article->getState() != -1) {
      array_push($params, $article->getState());
      array_push($query_parts, "state = ?");
    }

    array_push($params, $id, $listId);
    if (count($query_parts) == 0) {
      return null;
    }

    $query = "UPDATE article SET ";
    $query .= implode(", ", $query_parts);
    $query .= " WHERE id = ? and listId = ?";

    return \App\DataManager::update($query, $params);
  }

  public static function deleteById(int $id, int $listId)
  {
    $query = "DELETE FROM article WHERE id = ? AND listId = ?";
    \App\DataManager::delete($query, [$id, $listId]);
    return null;
  }
}