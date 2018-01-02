<?php

namespace Model;

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

  public static function buildUser($obj) {
	  return new User(
		  $obj->id,
		  $obj->username,
		  $obj->password
	  );
  }
}