<?php
/**
 * Autoloader class
 * @author Alan Willms
 */
class AutoLoader
{
	/**
	 * Return application base path
	 * @return string
	 */
	public static function getBasePath()
	{
		return realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
	}
	/**
	 * Return views base path
	 * @return string
	 */
	public static function getViewsPath()
	{
		return realpath(__DIR__ . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . 'views';
	}

	/**
	 * Load class
	 * @param string $className
	 * @return boolean
	 */
	public static function load($className)
	{
		$basePath = self::getBasePath();

		$pathsByPriority = array(
			'components',
			'models',
			'helpers',
			'controllers',
		);

		foreach ($pathsByPriority as $path) {

			$fileName = $basePath . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $className . '.php';

			if (file_exists($fileName)) {

				require_once $fileName;

				if (class_exists($className)) {
					return true;
				}
			}
		} 

		return false;
	}
}

spl_autoload_register('AutoLoader::load');