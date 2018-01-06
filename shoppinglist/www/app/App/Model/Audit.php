<?php

namespace App\Model;

class Audit extends Entity {

  const ACTION_LOGIN = "login";
  const ACTION_LOGOUT = "logout";
  const ACTION_REGISTER = "register";

  private $username;
  private $action;
  private $ip;
  private $userAgent;
  private $created_at;

  public function __construct(int $id, string $username, string $action, string $ip, string $userAgent, string $created_at) {
    parent::__construct($id);
    $this->username = $username;
    $this->action = $action;
    $this->ip = $ip;
    $this->userAgent = $userAgent;
    $this->created_at = $created_at;
  }

  public function getUsername() : string {
    return $this->username;
  }

  public function getAction() : string {
    return $this->action;
  }
  
  public function getIp() : string {
    return $this->ip;
  }

  public function getUserAgent() : string {
    return $this->userAgent;
  }
  
  public function getCreatedAt() : string {
    return $this->created_at;
  }

  public static function buildBO($obj) {
	  return new Audit(
		  $obj->id,
		  $obj->username,
      $obj->action,
      $obj->ip,
      $obj->userAgent,
      $obj->created_at
	  );
  }

  public static function buildDTO($obj) {
    return new Audit(
      -1,
      $obj["username"],
      $obj["action"],
      $obj["ip"],
      $obj["userAgent"],
      $obj["created_at"]
    );
  }

  public static function create(Audit $audit) : int 
  {
    $query = "INSERT INTO audit (username, action, ip, userAgent, created_at) VALUES (?, ?, ?, ?, ?);";
    return \App\DataManager::create($query, [
      $audit->username, 
      $audit->action,
      $audit->ip,
      $audit->userAgent,
      $audit->created_at]);
  }

  public static function getAll(string $username)
  {
    $query = "SELECT id, username, action, ip, userAgent, created_at FROM audit WHERE username = ?";
    return \App\DataManager::get($query, [$username], "\App\Model\Audit");
  }
}