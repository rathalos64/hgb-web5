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
  private $unfinishedArticles;

  public function __construct(int $id, int $userId, string $title, string $description, int $state, int $numberOfArticles, int $unfinishedArticles) {
    parent::__construct($id);
    $this->userId = $userId;
    $this->title = $title;
    $this->description = $description;
    $this->state = $state;
    $this->numberOfArticles = $numberOfArticles;
    $this->unfinishedArticles = $unfinishedArticles;
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

  public function getUnfinishedArticles() : int {
    return $this->unfinishedArticles;
  }

  public static function buildBO($obj) {
	  return new Liste(
      $obj->id,
      $obj->userId,
		  $obj->title,
      $obj->description,
      $obj->state,
      $obj->numberOfArticles,
      $obj->unfinishedArticles
	  );
  }

  public static function buildDTO($obj) {
    return new Liste(
      -1,
      $obj["userId"],
      $obj["title"],
      $obj["description"],
      $obj["state"],
      $obj["numberOfArticles"],
      $obj["unfinishedArticles"]
    );
  }

  public static function create(Liste $liste) : int 
  {
    $query = "INSERT INTO list (userId, title, description, state, numberOfArticles, unfinishedArticles) VALUES (?, ?, ?, ?, ?, ?);";
    return \App\DataManager::create($query, [
      $liste->userId,
      $liste->title,
      $liste->description,
      $liste->state,
      $liste->numberOfArticles,
      $liste->unfinishedArticles
    ]);
  }

  public static function getAll(int $userId)
  {
    $query = "SELECT id, userId, title, description, state, numberOfArticles, unfinishedArticles FROM list WHERE userId = ?";
    return \App\DataManager::get($query, [$userId], "\App\Model\Liste");
  }

  public static function getById(int $id, int $userId)
  {
    $query = "SELECT id, userId, title, description, state, numberOfArticles, unfinishedArticles FROM list WHERE id = ? AND userId = ?";
    $lists = \App\DataManager::get($query, [$id, $userId], "\App\Model\Liste");
    if (count($lists) > 0) {
      return $lists[0];
    }
    return null;
  }
}