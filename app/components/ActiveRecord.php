<?php
/**
 * A simple ActiveRecord class
 * @author Alan Willms
 */
abstract class ActiveRecord
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

	/**
	 * Return database table name for this model (by default lowercase model name)
	 * @return string
	 */
	public static function getDbTableName()
	{
		return strtolower(get_called_class());
	}

	/**
	 * Find All objects
	 * @param array $filtering Specifies query params (as WHERE, ORDER, etc.)
	 * @return ActiveRecord[]
	 */
	public static function all(array $filtering = array())
	{
		$model = get_called_class();

		$select = $where = $order = $limit = null;

		if (isset($filtering['order'])) {
			$order = 'ORDER BY ' . $model::prepareOrder($filtering['order']);
		}

		if (!isset($filtering['select'])) {
			$select = 'SELECT *';
		}

		$query = $select . ' FROM ' . $model::getDbTableName() . $where . $order . $limit;

		$statement = $model::getDb()->query($query);

		if (!$statement) {
			throw new Exception('Database query error');
		}

		$statement->setFetchMode(PDO::FETCH_CLASS, $model);

		$models = array();

		while ($model = $statement->fetch()) {
			$models[] = $model;
		}

		return $models;
	}

	/**
	 * Prepare ORDER BY clause
	 * @return string
	 */
	protected static function prepareOrder(array $attributes)
	{
		$orderBy = array();
		foreach ($attributes as $attribute => $order) {

			if ($model::hasAttribute($attribute)) {

				$order = strtoupper($order);

				$orderBy .= $attribute . ' ' . ($order == 'ASC') ? 'ASC' : 'DESC';
			}
		}

		return implode(', ', $orderBy);
	}
}