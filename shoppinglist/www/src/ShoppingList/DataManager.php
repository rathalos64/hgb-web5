<?php

namespace ShoppingList;

class DataManager {

	private static $__connection;

	private static function buildDSN() : string {
		$dsn = 'mysql:';
		$dsn .= 'host=' . Config::get('MYSQL_HOST') . ';';
		$dsn .= 'dbname=' . Config::get('MYSQL_DB') . ';';
		$dsn .= 'charset=utf8;';
		return $dsn;
	}

	/**
	 * connect to the database
	 * 
	 * note: alternatively put those in parameter list or as class variables
	 * 
	 * @return connection resource
	 */
	private static function getConnection() {
		if (!isset(self::$__connection)) {
			$dsn = self::buildDSN();
			// echo $dsn; 
			// echo "\n" . Config::get("MYSQL_USER");
			// echo "\n" . Config::get("MYSQL_PASSWORD");
			// exit();

			self::$__connection = new \PDO($dsn, Config::get("MYSQL_USER"), Config::get("MYSQL_PASSWORD"));
		}
		return self::$__connection;
	}

	/**
	 * place query
	 * 
	 * note: using prepared statements
	 * see the filtering in bindValue()
	 * 
	 * @return mixed
	 */
	private static function query($connection, $query, $parameters = array()) {
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

	/**
	 * get the key of the last inserted item
	 * 
	 * @return integer
	 */
	private static function lastInsertId($connection) {
		return $connection->lastInsertId();
	}

	/**
	 * retrieve an object from the database result set
	 * 
	 * @param object $cursor result set
	 * @return object
	 */
	private static function fetchObject($cursor) {
		return $cursor->fetchObject();
	}

	/**
	 * remove the result set
	 * 
	 * @param object $cursor result set
	 * @return null
	 */
	private static function close($cursor) {
		$cursor->closeCursor();
	}

	/**
	 * close the database connection
	 * 
	 * note: in PDO, simply set the instance of PDO to null
	 * 
	 * @param object $cursor resource of current database connection
	 * @return null
	 */
	private static function closeConnection($connection) {
		self::$__connection = null;
	}

	public static function createUser($username, $password) : int {
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

	  public static function getUserById($id) {
		$con = self::getConnection();
		
		$res = self::query($con, "
		  SELECT id, username, password 
		  FROM user
		  WHERE id = ?;
		  ", [$id]);
		
		  if ($fetched = self::fetchObject($res)) {
			self::close($res);
			self::closeConnection($con);
			return \Model\User::buildUser($fetched);
		  }
		
		self::close($res);
		self::closeConnection($con);
		return null;
	  }

	  public static function getUserByUsername($username) {
		$con = self::getConnection();
		
		$res = self::query($con, "
		  SELECT id, username, password 
		  FROM user
		  WHERE username = ?;
		  ", [$username]);
		
		  if ($fetched = self::fetchObject($res)) {
			self::close($res);
			self::closeConnection($con);
			return \Model\User::buildUser($fetched);
		  }
		
		self::close($res);
		self::closeConnection($con);
		return null;
	  }
}