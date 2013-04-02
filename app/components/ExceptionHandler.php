<?php
/**
 * Exceptions handler
 * @author Alan Willms
*/
class ExceptionHandler
{
	/**
	 * Handle exceptions for production environtment.
	 * In a real scenario it would save logs.....
	 */
	public static function handle($exception)
	{
		$errorPage = '500';

		if ($exception->getCode() == 404) {
			$errorPage = '404';
		}

		ob_clean();
		include AutoLoader::getViewsPath() . DIRECTORY_SEPARATOR . $errorPage . '.html';
	}
}