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
	 * Hold current controller instance
	 * @var Controller
	 */
	private static $_controller;

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

		$urlConfig = ($this->_config && isset($this->_config['url'])) ? $this->_config['url'] : false;

		$this->setupUrlManager($urlConfig);

		$isDevelopmentEnv = (isset($this->_config['environment']) && $this->_config['environment'] == 'development');

		$this->setupEnvironment($isDevelopmentEnv);
	}

	/**
	 * Setup isDevelopmentEnv
	 * @param boolean $isDevelopmentEnv
	 */
	public function setupEnvironment($isDevelopmentEnv)
	{
		$errorLevels = 0;
		$enableErrors = 0;

		if ($isDevelopmentEnv) {

			$errorLevels = (E_ALL | E_STRICT);
			$enableErrors = 1;
		}
		else {

			set_exception_handler('ExceptionHandler::handle');
		}

		error_reporting($errorLevels);
		ini_set('display_errors', $enableErrors);
	}

	/**
	 * Setup a default DB connection to all ActiveRecord adapters
	 * @param array $config
	 */
	public function setupDataBase($config)
	{
		$requiredInfo = array('engine', 'database', 'host', 'username', 'password', 'charset');
		$availableInfo = array_keys($config);

		foreach ($requiredInfo as $info) {
			if (!in_array($info, $availableInfo) || null === $config[$info]) {
				throw new Exception('You must inform database ' . $info . ' in the config file');
			}
		}

		$dns = $config['engine'] . ':dbname=' . $config['database'] . ";host=" . $config['host'] . ";charset=" . $config['charset']; 
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
			throw new Exception('Controller class "' . $controllerClass . '" not found', 404);
		}

		$controller = new $controllerClass;

		// If it can't find action method
		if (false == method_exists($controller, $actionMethod)) {
			throw new Exception('Action method "' . $actionMethod . '"  not found', 404);
		}

		self::$_controller = $controller;

		$controller->$actionMethod();
	}

	/**
	 * Return current controller instance
	 * @return Controller
	 */
	public static function getController()
	{
		return self::$_controller;
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

		return include $configFilePath;
	}
}