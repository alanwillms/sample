<?php
/**
 * A simple ActiveRecord class
 * @author Alan Willms
 */
abstract class ActiveRecord
{
	/**
	 * ActiveRecord attributes values
	 * @var array
	 */
	protected $_attributes = array();

	/**
	 * ActiveRecord attributes errors
	 * @var array
	 */
	protected $_errors = array();

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
	 * Initialize ActiveRecord model
	 */
	public function __construct()
	{
		$this->_attributes = array();

		foreach ($this->getAttributesNames() as $attribute) {
			$this->_attributes[$attribute] = null;
		}
	}

	/**
	 * Magic getter to deal with ActiveRecord attributes
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		if ($this->hasAttribute($name)) {
			return $this->_attributes[$name];
		}

		if ($name == 'attributes') {

			return $this->_attributes;
		}

		throw new Exception('Undefined attribute "' . $name . '"');
	}

	/**
	 * Magic getter to deal with ActiveRecord attributes
	 * @param string $name
	 * @return mixed
	 */
	public function __set($name, $value)
	{
		if ($this->hasAttribute($name)) {

			$this->_attributes[$name] = $value;

			return $this;
		}

		if ($name == 'attributes' && is_array($value)) {

			foreach ($value as $name => $v) {
				$this->$name = $v;
			}

			return $this;
		}

		throw new Exception('Undefined attribute "' . $name . '"');
	}

	/**
	 * Method overriten for validations.
	 * <code>
	 * // Each attribute can have multiple errors
	 * $this->addError($attribute, 'Error message');
	 * </code>
	 */
	public function validate()
	{

	}

	/**
	 * Add an error to an attribute
	 * @param string $attribute
	 * @param string $error
	 */
	public function addError($attribute, $error)
	{
		if (!isset($this->_errors[$attribute])) {
			$this->_errors[$attribute] = array();
		}

		$this->_errors[$attribute][] = $error;
	}

	/**
	 * Return object errors (if it has any)
	 * @param string $attribute If informed, will only look for errors on this attribute
	 * @return array
	 */
	public function getErrors($attribute = null)
	{
		if ($attribute) {

			if (isset($this->_errors[$attribute])) {
				return $this->_errors[$attribute];
			}
			else {
				return array();
			}
		}

		return $this->_errors;
	}

	/**
	 * Return if any (or some) attribute contain errors or not
	 * @param string $attribute If informed, will only look for errors on this attribute
	 * @return boolean
	 */
	public function hasErrors($attribute = null)
	{
		if ($attribute) {

			return (isset($this->_errors[$attribute]) && count($this->_errors[$attribute]));
		}

		return count($this->_errors);
	}

	/**
	 * Save ActiveRecord model to database table
	 */
	public function save()
	{
		$this->validate();

		if ($this->hasErrors()) {
			return false;
		}

		$pk = $this->getPrimaryKeyName();
		$table = $this->getDbTableName();
		$attributes = $this->getAttributesNames();

		unset($attributes[$pk]);

		$query = null;

		if ($this->$pk) {

			$query = 'UPDATE ' . $table . ' SET ';

			$params = array();

			foreach ($attributes as $attribute) {
				$params[] = $attribute . ' = :' . $attribute;
			}

			$query .= implode(', ', $params) . $this->prepareWhere(array($pk => $this->$pk));
		}
		else {

			$query = 'INSERT INTO ' . $table;
			$query .= ' (' . implode(', ', $attributes ) . ') ';
			$query .= ' VALUES (:' . implode(', :', $attributes ) . ' ) ';
		}

		$statement = $this->getDb()->prepare($query);

		if (!$statement) {
			throw new Exception('Query error');
		}

		foreach ($this->attributes as $attribute => $value) {

			if ($attribute != $pk)
				$statement->bindValue(':' . $attribute, $value);
		}

		return $statement->execute();
	}

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
	public static function getAttributesNames()
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
		return in_array($attribute, $model::getAttributesNames());
	}

	/**
	 * Get PK attribute name
	 * @return string
	 */
	public static function getPrimaryKeyName()
	{
		$model = get_called_class();

		foreach ($model::getDbTableInfo() as $column) {

			if ($column['Key'] == 'PRI')
				return $column['Field'];
		}

		throw new Exception('Unknown primary key column name');
	}

	/**
	 * Find all objects
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

		if (isset($filtering['limit'])) {
			$limit = $model::prepareLimit($filtering['limit']);
		}

		if (isset($filtering['where'])) {
			$where = $model::prepareWhere($filtering['where']);
		}

		if (!isset($filtering['select'])) {
			$select = 'SELECT *';
		}

		$query = $select . ' FROM ' . $model::getDbTableName() . $where . $order . $limit;

		$statement = $model::getDb()->query($query);

		if (!$statement) {
			throw new Exception('Database query error');
		}

		$models = array();

		while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

			$object = new $model();
			$object->attributes = $row;

			$models[] = $object;
		}

		return $models;
	}

	/**
	 * Find one object
	 * @param array $filtering Specifies query params (as WHERE, ORDER, etc.)
	 * @return ActiveRecord
	 */
	public static function find(array $filtering = array())
	{
		$model = get_called_class();

		$filtering['limit'] = 1;

		$objects = $model::all($filtering);

		if ($objects) {
			return array_pop($objects);
		}

		return null;
	}

	/**
	 * Find one object by its primary key
	 * @param integer $id
	 * @return ActiveRecord
	 */
	public static function findByPk($id)
	{
		$model = get_called_class();
		$pk = $model::getPrimaryKeyName();

		return $model::find(array('where' => array($pk => intval($id))));
	}

	/**
	 * Prepare ORDER BY clause
	 * @param array $attributes
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

	/**
	 * Prepare LIMIT clause
	 * @param integer $limit
	 * @return string
	 */
	protected static function prepareLimit($limit)
	{
		$limit = intval($limit);

		if ($limit) {
			return ' LIMIT ' . $limit;
		}

		return null;
	}

	
	/**
	 * Prepare WHERE clause
	 * @param mixed $conditions
	 * @return string
	 */
	protected static function prepareWhere($conditions)
	{
		$condition = null;

		if (is_array($conditions)) {

			$where = array();
			$model = get_called_class();

			foreach ($conditions as $attribute => $value) {

				if (!is_numeric($attribute)) {

					if (is_string($value)) {
						$value = $model::getDb()->quote($value);
					}

					$value = $attribute . ' = ' . $value;
				}
				
				$where[] = $value;
			}

			if (count($where)) {
				$condition = implode(' AND ', $where);
			}
		}

		if ($condition) {
			return ' WHERE ' . $condition;
		}

		return null;
	}
}