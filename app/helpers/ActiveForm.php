<?php
/**
 * ActiveRecord models form view helper
 */
class ActiveForm
{
	protected $_object;

	public function __construct(ActiveRecord $object)
	{
		$this->_object = $object;
	}

	/**
	 * Starts the new form and render possible errors
	 */
	public function open()
	{
		echo '<form method="POST" class="form-horizontal">';

		if ($this->_object->hasErrors()) {
			$this->errors();
		}
	}

	/**
	 * Close the form
	 */
	public function close()
	{
		echo '</form>';
	}

	/**
	 * Render object errors
	 */ 
	public function errors()
	{
		$html = '<div class="alert alert-error"><ul>';

		foreach ($this->_object->getErrors() as $attribute => $errors) {

			$html .= '<li>' . implode('. ', $errors) . '</li>';
		}

		$html .= '</ul></div>';

		echo $html;
	}

	/**
	 * Open a new field row
	 */
	public function openField($attribute)
	{
		$fieldId = $this->getHtmlId($attribute);
		$fieldLabel = $this->_object->getAttributeLabel($attribute);

		$extraClass = '';

		if ($this->_object->hasErrors($attribute)) {
			$extraClass = ' error';
		}

		echo '
		<div class="control-group'. $extraClass . '">
			<label class="control-label" for="' . $fieldId . '">' . $fieldLabel . '</label>
			<div class="controls">'
		;
	}

	/**
	 * Close a new field row
	 */
	public function closeField($attribute)
	{
		if ($this->_object->hasErrors($attribute)) {

			$errors = implode('. ', $this->_object->getErrors($attribute));

			echo '<span class="help-inline">' . $errors . '</span>';
		}

		echo '</div>
		</div>';
	}

	/**
	 * Render a input
	 */
	public function textArea($attribute)
	{
		$this->openField($attribute);

		$fieldId = $this->getHtmlId($attribute);
		$fieldName = $this->getHtmlName($attribute);

		echo '<textarea id="', $fieldId,
		     '" name="', $fieldName, '">',
		     htmlspecialchars($this->_object->$attribute),
		     '</textarea>'
		;

		$this->closeField($attribute);
	}

	/**
	 * Render a input
	 */
	public function input($type, $attribute)
	{
		$this->openField($attribute);

		$fieldId = $this->getHtmlId($attribute);
		$fieldName = $this->getHtmlName($attribute);

		echo '<input type="', $type, '" id="', $fieldId,
		     '" name="', $fieldName, '" value="',
		     htmlspecialchars($this->_object->$attribute), '" />'
		;

		$this->closeField($attribute);
	}

	/**
	 * Render a text input
	 */
	public function textInput($attribute)
	{
		$this->input('text', $attribute);
	}

	/**
	 * Render an e-mail input
	 */
	public function emailInput($attribute)
	{
		$this->input('email', $attribute);
	}

	/**
	 * Render buttons
	*/
	public function buttons()
	{
		$cancelUrl = Application::getController()->createUrl('index');

		echo '<div class="form-actions">
			<input type="submit" value="Save" class="btn btn-primary" />
			<a href="', $cancelUrl, '" class="btn">Cancel</a>
		</div>';
	}

	/**
	 * HTML ID for an attribute
	 * @return string
	 */
	protected function getHtmlId($attribute)
	{
		return get_class($this->_object) . '_' . $attribute;
	}

	/**
	 * HTML name for an attribute
	 * @return string
	 */
	protected function getHtmlName($attribute)
	{
		return get_class($this->_object) . '[' . $attribute . ']';
	}
}