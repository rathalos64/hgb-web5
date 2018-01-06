<?php

namespace App\Model;

class User extends Entity {

  private $username;
  private $password;

  public function __construct(int $id, string $username, string $password) {
    parent::__construct($id);
    $this->username = $username;
    $this->password = $password;
  }

  public function getUsername() : string {
    return $this->username;
  }

  public function getPassword() : string {
    return $this->password;
  }

  public static function buildBO($obj) {
	  return new User(
		  $obj->id,
		  $obj->username,
		  $obj->password
	  );
  }

  public static function buildDTO($obj) {
    return new User(
      -1,
      $obj["username"],
      $obj["password"]
    );
  }

  public static function create(User $user) : int 
  {
    $query = "INSERT INTO user (username, password) VALUES (?, ?);";
    return \App\DataManager::create($query, [$user->username, $user->password]);
  }

  public static function getById(int $id)
  {
    $query = "SELECT id, username, password FROM user WHERE id = ?";
    $users = \App\DataManager::get($query, [$id], "\App\Model\User");
    if (count($users) > 0) {
      return $users[0];
    }
    return null;
  }

  public static function getByUsername(string $username) 
  {
    $query = "SELECT id, username, password FROM user WHERE username = ?";
    $users = \App\DataManager::get($query, [$username], "\App\Model\User");
    if (count($users) > 0) {
      return $users[0];
    }
    return null;
  }
}