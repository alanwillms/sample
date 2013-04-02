<?php
/**
 * Grid helper
 */
class GridViewHelper
{
	public $className;
	public $listedAttributes;
	public $objects;
	public $actionLinks;

	/**
	 * Outputs formatted HTML
	 * @return string
	 */
	public function render($controller)
	{
		if (count($this->objects) == 0)  {
			return '<p>No records found.</p>';
		}

		$html = '
		<table class="table table-striped">
			<thead>
				<tr>';

		$className = $this->className;

		foreach ($this->listedAttributes as $attribute) {

			$direction = 'asc';

			if (isset($_GET[$className]) && isset($_GET[$className][$attribute])) {

				$direction = ($_GET[$className][$attribute] == 'asc') ? 'desc' : 'asc';
			}

			$sortUrl = $controller->createUrl('index', array($this->className => array($attribute => $direction)));

			$html .= '<th><a href="' . $sortUrl . '">' . $className::getAttributeLabel($attribute) . '</a></th>';
		}

		foreach ($this->actionLinks as $action => $label) {
			$html .= '<th>&nbsp;</th>';
		}

		$html .= '
				</tr>
			</thead>
			<tbody>';

		foreach ($this->objects as $object) {

			$html .= '
				<tr>
			';

			foreach ($this->listedAttributes as $attribute) {

				$html .= '<td>' . $object->$attribute . '</td>';
			}

			$pk = $object->getPrimaryKeyName();

			foreach ($this->actionLinks as $action => $label) {

				$url = $controller->createUrl($action, array($pk => $object->$pk));

				$html .= '<td><a href="' . $url . '">' . $label . '</a></td>';
			}
			
			$html .= '
				</tr>
			';
		}

		$html .= '
			</tbody>
		</table>';

		return $html;
	}
}