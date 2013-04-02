<?php
/**
 * Sortable grid view helper
 */
class SortableGrid
{
	public $className;
	public $listedAttributes;
	public $objects;
	public $actionLinks;

	/**
	 * Outputs formatted HTML
	 * @return string
	 */
	public function render()
	{
		if (count($this->objects) == 0)  {
			return '<p>No records found.</p>';
		}

		$controller = Application::getController();

		$html = '
		<table class="table table-striped">
			<thead>
				<tr>';

		$className = $this->className;

		foreach ($this->listedAttributes as $attribute) {

			$direction = 'asc';

			$label = $className::getAttributeLabel($attribute);

			$htmlClass = 'sorting-none';
			$htmlTitle = 'Sort by ' . $label;

			if (isset($_GET[$className]) && isset($_GET[$className][$attribute])) {

				if ($_GET[$className][$attribute] == 'asc') {
					$direction = 'desc';
					$htmlClass = 'sorting-desc';
				}
				else {
					$direction = 'asc';
					$htmlClass = 'sorting-asc';
				}
			}

			$sortUrl = $controller->createUrl('index', array($this->className => array($attribute => $direction)));

			$html .= '<th class="' . $htmlClass . '"><a href="' . $sortUrl . '" title="' . $htmlTitle . '">' . $label . '</a></th>';
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

				$html .= '<td>' . htmlspecialchars($object->$attribute) . '</td>';
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