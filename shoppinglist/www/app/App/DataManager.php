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

	private static function fetchAll($cursor)
	{
		return $cursor->fetchAll();
	}

	private static function close($cursor) 
	{
		$cursor->closeCursor();
	}

	private static function closeConnection($connection) 
	{
		self::$__connection = null;
	}

	public static function create($query, $params) : int
	{
		$con = self::getConnection();
	
		// necessary for correct Exception to enable rollback
		$con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$con->beginTransaction();
	
		try {
			self::query($con, $query, $params);
			$id = self::lastInsertId($con);
			$con->commit();
		} catch (\Exception $e) {
	
			// one of the queries failed - complete rollback
			$con->rollBack();
			self::closeConnection($con);

			throw $e;
			return null;
		}

		self::closeConnection($con);
		return $id;
	}

	public static function get($query, $params, $model) 
	{
		$con = self::getConnection();
		$res = self::query($con, $query, $params);
		
		$objects = [];
		while ($fetched = self::fetchObject($res)) {
			array_push($objects, $model::buildBO($fetched));
		}

		self::close($res);
		self::closeConnection($con);
		return $objects;
	}
}