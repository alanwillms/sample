<?php
/**
 * Person model
 */
class Person extends ActiveRecord
{
	/**
	 * Return database table name for this model
	 * @return string
	 */
	public static function getDbTableName()
	{
		return 'people';
	}
}