<?php
/**
 * Base application class
 * @author Alan Willms
 */
class Application
{
	/**
	 * Application config data
	 * @var array
	 */
	private $_config;

	/**
	 * URL manager object
	 * @var UrlManager
	 */
	private $_urlManager;

	/**
	 * Requires application initial config file to be loaded
	 * @param string $configFilePath
	 */
	public function __construct($configFilePath)
	{
		$this->_config = $this->loadConfigFile($configFilePath);

		if ($this->_config && isset($this->_config['dataBase'])) {
			$this->setupDataBase($this->_config['dataBase']);
		}

		$urlConfig = (isset($this->_config['url'])) ? $this->_config['url'] : false;

		$this->setupUrlManager($urlConfig);
	}

	/**
	 * Setup a default DB connection to all ActiveRecord adapters
	 * @param array $config
	 */
	public function setupDataBase($config)
	{
		$dns = $config['engine'] . ':dbname=' . $config['database'] . ";host=" . $config['host']; 
		$pdo = new PDO($dns, $config['username'], $config['password']);

		ActiveRecord::setDb($pdo);
	}

	/**
	 * Setup URL manager
	 * @param array $config
	 */
	public function setupUrlManager($config)
	{
		$this->_urlManager = new UrlManager;

		if ($config && is_array($config)) {

			if (isset($config['defaultController'])) {
				$this->_urlManager->defaultController = $config['defaultController'];
			}

			if (isset($config['defaultAction'])) {
				$this->_urlManager->defaultAction = $config['defaultAction'];
			}
		}
	}

	/**
	 * Run application
	 */
	public function run()
	{
		$controllerName = $this->_urlManager->getControllerName();
		$actionName = $this->_urlManager->getActionName();

		$controllerClass = ucfirst($controllerName) . 'Controller';
		$actionMethod = 'action' . ucfirst($actionName);

		// If it can't find controller class
		if (false == AutoLoader::load($controllerClass)) {
			throw new Exception('Controller not found', 404);
		}

		$controller = new $controllerClass;

		// If it can't find action method
		if (false == method_exists($controller, $actionMethod)) {
			throw new Exception('Action not found', 404);
		}

		$controller->$actionMethod();
	}

	/**
	 * Loads application config file
	 * @param string $configFilePath
	 * @throws Exception
	 */
	private function loadConfigFile($configFilePath)
	{
		if (!file_exists($configFilePath)) {
			throw new Exception('Config file not found: ' . $configFilePath);
		}

		include $configFilePath;
	}
}