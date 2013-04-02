<?php
/**
 * Controller base class
 * @author Alan Willms
 */
abstract class Controller
{
	/**
	 * Return current controller ID
	 * @return string
	 */
	protected function getId()
	{
		$className = get_class($this);

		return lcfirst(
			substr($className, 0, strlen($className) - 10)
		);
	}

	/**
	 * Get application base URL
	 * @return string
	 */
	protected function getBaseUrl()
	{
		return UrlManager::getBaseUrl();
	}

	/**
	 * Create a URL based on a controller/action ID and params
	 * @param string $request controller/action or action
	 * @param array $params
	 * @return string
	 */
	protected function createUrl($request, array $params = array())
	{
		$request = explode('/', $request);

		if (count($request) == 1) {
			array_unshift($request, $this->getId());
		}

		$request = implode('/', $request);

		$url = $this->getBaseUrl() . '?r=' . $request;

		if (count($params)) {
			$url .= '&' . http_build_query($params);
		}

		return $url;
	}

	/**
	 * Render view within application layout
	 * @param string $viewFileName
	 * @param array $viewParams Variables exported to view
	 */
	protected function render($viewFileName, $viewParams = array())
	{
		$__viewLayoutPath = AutoLoader::getViewsPath() . DIRECTORY_SEPARATOR . 'layout.php';

		if (false == file_exists($__viewLayoutPath)) {
			throw new Exception('Layout file not found in "' . $__viewLayoutPath . '"');
		}

		ob_start();
		$this->renderPartial($viewFileName, $viewParams);
		$content = ob_get_contents();
		ob_end_clean();

		include $__viewLayoutPath;
	}

	/**
	 * Render partial view, with no layout
	 * @param string $viewFileName
	 * @param array $viewParams Variables exported to view
	 */
	protected function renderPartial($viewFileName, $viewParams = array())
	{
		$__viewFilePath = AutoLoader::getViewsPath() . DIRECTORY_SEPARATOR . $this->getId() . DIRECTORY_SEPARATOR . $viewFileName . '.php';

		if (false == file_exists($__viewFilePath)) {
			throw new Exception('View file not found in "' . $__viewFilePath . '"');
		}

		extract($viewParams);

		include $__viewFilePath;
	}
}