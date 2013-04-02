<?php
/**
 * Generate URLs and detect params
 * @author Alan Willms
 */
class UrlManager
{
	/**
	 * Application base URL
	 * @var string
	 */
	private static $_baseUrl;

	/**
	 * Default controller if not informed
	 * @var string
	 */
	public $defaultController = 'index';

	/**
	 * Default action if not informed
	 * @var string
	 */
	public $defaultAction = 'index';

	/**
	 * Return the current controller name
	 * @return string
	 */
	public function getControllerName()
	{
		if (isset($_GET['r']) && $_GET['r']) {

			$params = explode('/', $_GET['r']);

			return self::filterName($params[0]);
		}

		return $this->defaultController;
	}

	/**
	 * Return the current action name
	 * @return string
	 */
	public function getActionName()
	{
		if (isset($_GET['r'])) {

			$params = explode('/', $_GET['r']);

			if (isset($params[1]) && $params[1]) {

				return self::filterName($params[1]);
			}
		}

		return $this->defaultAction;
	}

	/**
	 * Get application base URL
	 * @return string
	 */
	public static function getBaseUrl()
	{
		if (null === self::$_baseUrl) {

			self::$_baseUrl = rtrim(dirname($_SERVER['PHP_SELF']),'\\/');
		}

		return self::$_baseUrl;
	}

	/**
	 * Filter a request name
	 * @param string $name
	 * @return string
	 */
	public static function filterName($name)
	{
		return preg_replace('/[^A-Za-z0-9]/', '', $name);
	}
}