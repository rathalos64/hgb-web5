<?php

namespace App\Model;

class Liste extends Entity {

  const STATE_FINISHED = 1;
  const STATE_LEFT_ARTICLES = 2;
  const STATE_NO_ARTICLES = 3;

  private $userId;
  private $title;
  private $description;
  private $state;
  private $numberOfArticles;
  private $finishedArticles;

  public function __construct(int $id, int $userId, string $title, string $description, int $state, int $numberOfArticles, int $finishedArticles) {
    parent::__construct($id);
    $this->userId = $userId;
    $this->title = $title;
    $this->description = $description;
    $this->state = $state;
    $this->numberOfArticles = $numberOfArticles;
    $this->finishedArticles = $finishedArticles;
  }

  public function getUserId() : int {
    return $this->userId;
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

  public function getNumberOfArticles() : int {
    return $this->numberOfArticles;
  }

  public function getFinishedArticles() : int {
    return $this->finishedArticles;
  }

  public static function buildBO($obj) {
	  return new Liste(
      $obj->id,
      $obj->userId,
		  $obj->title,
      $obj->description,
      $obj->state,
      $obj->numberOfArticles,
      $obj->finishedArticles
	  );
  }

  public static function buildDTO($obj) 
  {
    return new Liste(
      -1,
      $obj["userId"],
      $obj["title"],
      $obj["description"],
      $obj["state"],
      $obj["numberOfArticles"],
      $obj["finishedArticles"]
    );
  }

  public static function buildUpdateDTO($obj) 
  {
    return new Liste(
      -1,
      $obj["userId"] ?? -1,
      $obj["title"] ?? "",
      $obj["description"] ?? "",
      $obj["state"] ?? -1,
      $obj["numberOfArticles"] ?? -1,
      $obj["finishedArticles"] ?? -1
    );
  }

  public static function create(Liste $liste) : int 
  {
    $query = "INSERT INTO list (userId, title, description, state, numberOfArticles, finishedArticles) VALUES (?, ?, ?, ?, ?, ?);";
    return \App\DataManager::create($query, [
      $liste->userId,
      $liste->title,
      $liste->description,
      $liste->state,
      $liste->numberOfArticles,
      $liste->finishedArticles
    ]);
  }

  public static function getAll(int $userId)
  {
    $query = "SELECT id, userId, title, description, state, numberOfArticles, finishedArticles FROM list WHERE userId = ? ORDER BY state DESC";
    return \App\DataManager::get($query, [$userId], "\App\Model\Liste");
  }

  public static function getById(int $id, int $userId)
  {
    $query = "SELECT id, userId, title, description, state, numberOfArticles, finishedArticles FROM list WHERE id = ? AND userId = ?";
    $lists = \App\DataManager::get($query, [$id, $userId], "\App\Model\Liste");
    if (count($lists) > 0) {
      return $lists[0];
    }
    return null;
  }

  public static function updateById(int $id, int $userId, Liste $liste) : int
  {
    $params = [];
    $query_parts = [];

    if ($liste->getTitle() != "") {
      array_push($params, $liste->getTitle());
      array_push($query_parts, "title = ?");
    }

    if ($liste->getDescription() != "") {
      array_push($params, $liste->getDescription());
      array_push($query_parts, "description = ?");
    }

    if ($liste->getState() != -1) {
      array_push($params, $liste->getState());
      array_push($query_parts, "state = ?");
    }

    if ($liste->getNumberOfArticles() != -1) {
      array_push($params, $liste->getNumberOfArticles());
      array_push($query_parts, "numberOfArticles = ?");
    }

    if ($liste->getFinishedArticles() != -1) {
      array_push($params, $liste->getFinishedArticles());
      array_push($query_parts, "finishedArticles = ?");
    }

    array_push($params, $id, $userId);
    if (count($query_parts) == 0) {
      return null;
    }

    $query = "UPDATE list SET ";
    $query .= implode(", ", $query_parts);
    $query .= " WHERE id = ? and userId = ?";

    return \App\DataManager::update($query, $params);
  }

  public static function deleteById(int $id, int $userId)
  {
    $query = "DELETE FROM list WHERE id = ? AND userId = ?";
    \App\DataManager::delete($query, [$id, $userId]);
    return null;
  }
}