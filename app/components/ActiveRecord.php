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
	 * Information about database tables
	 * @var array
	 */
	private static $_dbTableInfo = array();

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
	 * Return informations about database table for current model.
	 * @return array
	 */
	public static function getDbTableInfo()
	{
		$model = get_called_class();

		if (!isset(self::$_dbTableInfo[$model])) {

			$statement = $model::getDb()->prepare('DESCRIBE ' . $model::getDbTableName());

			$statement->execute();

			self::$_dbTableInfo[$model] = $statement->fetchAll(PDO::FETCH_ASSOC);
		}

		return self::$_dbTableInfo[$model];
	}

	/**
	 * Return attributes names
	 * @return array
	 */
	public static function getAttributes()
	{
		$model = get_called_class();
		$attributes = array();

		foreach ($model::getDbTableInfo() as $column) {
			$attributes[$column['Field']] = $column['Field'];
		}

		return $attributes;
	}

	/**
	 * Check if model contains certain attribute
	 * @param string $attribute
	 * @return boolean
	 */
	public static function hasAttribute($attribute)
	{
		$model = get_called_class();
		return in_array($attribute, $model::getAttributes());
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
			$order = $model::prepareOrder($filtering['order']);
		}

		if (!isset($filtering['select'])) {
			$select = 'SELECT *';
		}

		$query = $select . ' FROM ' . $model::getDbTableName() . $where . $order . $limit;

		$statement = $model::getDb()->query($query);

		if (!$statement) {
			die($query);
			throw new Exception('Database query error');
		}

		$statement->setFetchMode(PDO::FETCH_CLASS, $model);

		return $statement->fetchAll();
	}

	/**
	 * Prepare ORDER BY clause
	 * @return string
	 */
	protected static function prepareOrder(array $attributes)
	{
		$model = get_called_class();
		$orderBy = array();

		foreach ($attributes as $attribute => $order) {

			if ($model::hasAttribute($attribute)) {

				$orderBy[] = ($attribute . ' ' . ((strtoupper($order) == 'ASC') ? 'ASC' : 'DESC'));
			}
		}

		if ($orderBy) {
			return ' ORDER BY ' . implode(', ', $orderBy);
		}

		return null;
	}
}