<?php
/**
 * Person model
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $country
 * @property string $city
 * @property string $address
 * @property string $email
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

	/**
	 * Validations
	 */
	public function validate()
	{
		$requiredAttributes = array('first_name', 'last_name', 'country', 'city', 'address', 'email');

		foreach ($requiredAttributes as $attribute) {

			if (!$this->$attribute) {
				$label = $this->getAttributeLabel($attribute);
				$this->addError($attribute, $label . ' is required');
			}
		}

		// Only validates e-mail if it has been entered
		if ($this->email) {

			if (false == filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
				$this->addError('email', 'This is not a valid e-mail address');
			}
		}
	}
}