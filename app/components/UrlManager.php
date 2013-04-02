<?php
/**
 * Generate URLs and detect params
 * @author Alan Willms
 */
class UrlManager
{
	public $defaultController = 'index';
	public $defaultAction = 'index';

	public function getControllerName()
	{
		if (isset($_GET['r'])) {

			$params = explode('/', $_GET['r']);

			return self::filterName($params[0]);
		}

		return $this->defaultController;
	}

	public function getActionName()
	{
		if (isset($_GET['r'])) {

			$params = explode('/', $_GET['r']);

			if (isset($params[1])) {

				return self::filterName($params[1]);
			}
		}

		return $this->defaultAction;
	}

	public static function filterName($fileName)
	{
		return preg_replace('/[^A-Za-z0-9]/', '', $fileName);
	}
}