<?php

namespace App;

class DataManager {

	private static $__connection;

	private static function buildDSN() : string 
	{
		$dsn = 'mysql:';
		$dsn .= 'host=' . Config::get('MYSQL_HOST') . ';';
		$dsn .= 'dbname=' . Config::get('MYSQL_DB') . ';';
		$dsn .= 'charset=utf8;';
		return $dsn;
	}

	private static function getConnection() 
	{
		if (!isset(self::$__connection)) {
			$dsn = self::buildDSN();
			self::$__connection = new \PDO($dsn, Config::get("MYSQL_USER"), Config::get("MYSQL_PASSWORD"));
		}
		return self::$__connection;
	}

	private static function query($connection, $query, $parameters = array()) 
	{
		$statement = $connection->prepare($query);
		$i = 1;
		foreach ($parameters as $param) {
			if (is_int($param)) {
				$statement->bindValue($i, $param, \PDO::PARAM_INT);
			}  
			if (is_string($param)) {
				$statement->bindValue($i, $param, \PDO::PARAM_STR);
			}  
			$i++;
		}
		$statement->execute();
		return $statement;
	}

	private static function lastInsertId($connection) 
	{
		return $connection->lastInsertId();
	}

	private static function fetchObject($cursor) 
	{
		return $cursor->fetchObject();
	}

	private static function close($cursor) 
	{
		$cursor->closeCursor();
	}

	private static function closeConnection($connection) 
	{
		self::$__connection = null;
	}

	public static function createUser($username, $password) : int 
	{
		$con = self::getConnection();
	
		// necessary for correct Exception to enable rollback
		$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	
		$con->beginTransaction();
	
		try {

		  self::query(
			  $con, 
			  "INSERT INTO user (username, password) VALUES (?, ?);", 
			  [$username, $password]);

		  $userId = self::lastInsertId($con);
		  $con->commit();
		
		} catch (\Exception $e) {
	
		  // one of the queries failed - complete rollback
		  $con->rollBack();
		  self::closeConnection($con);

		  throw $e;
		  return null;
		}

		self::closeConnection($con);
		return $userId;
	  }

	  public static function getUserById($id) 
	  {
		$con = self::getConnection();
		
		$res = self::query($con, "
		  SELECT id, username, password 
		  FROM user
		  WHERE id = ?;
		  ", [$id]);
		
		  if ($fetched = self::fetchObject($res)) {
			self::close($res);
			self::closeConnection($con);
			return Model\User::buildUser($fetched);
		  }
		
		self::close($res);
		self::closeConnection($con);
		return null;
	  }

	  public static function getUserByUsername($username) 
	  {
		$con = self::getConnection();
		
		$res = self::query($con, "
		  SELECT id, username, password 
		  FROM user
		  WHERE username = ?;
		  ", [$username]);
		
		  if ($fetched = self::fetchObject($res)) {
			self::close($res);
			self::closeConnection($con);
			return Model\User::buildUser($fetched);
		  }
		
		self::close($res);
		self::closeConnection($con);
		return null;
	  }
}