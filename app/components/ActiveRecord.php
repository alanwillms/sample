<?php
/**
 * A simple ActiveRecord class
 * @author Alan Willms
 */
class ActiveRecord
{
	/**
	 * PDO DB adapter
	 * @var PDO
	 */
	private static $_db;

	/**
	 * Set PDO DB adapter
	 * @param PDO $dbAdapter
	 */
	public static function setDb(PDO $dbAdapter)
	{
		self::$_db = $dbAdapter;
	}

	/**
	 * Get PDO DB adapter
	 * @return PDO
	 */
	public static function getDb()
	{
		return self::$_db;
	}
}