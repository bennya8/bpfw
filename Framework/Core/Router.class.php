<?php

/**
 * 系统URL路由类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Router extends Component
{
	/**
	 * 控制器名
	 * @access private
	 * @var string
	 */
	private $_controller = '';
	/**
	 * 行为名
	 * @access private
	 * @var string
	 */
	private $_action = '';
	/**
	 * URL参数
	 * @access private
	 * @var array
	 */
	private $_params = array();

	/**
	 * URL分析，解析出正确URL位置
	 * @access public
	 * @return void
	 */
	public function parseUrl()
	{
		if ($this->URL_MODE === 'PATH_INFO' && isset($_SERVER['PATH_INFO'])) {
			$url = explode('/', trim(str_replace('\\', '/', $_SERVER['PATH_INFO']), '/'));
			$this->_controller = !empty($url[0]) ? $url[0] : $this->DEFAULT_CONTROLLER;
			$this->_action = !empty($url[1]) ? $url[1] : $this->DEFAULT_ACTION;
			if (!empty($url[2])) {
				$key = $value = array();
				for ($i = 2, $len = count($url); $i < $len; $i++) {
					if ($i % 2 == 0) {
						$key[] = $url[$i];
					} else {
						$value[] = $url[$i];
					}
				}
				$this->_params = array_combine($key, $value);
				$_GET = $this->_params + $_GET;
			}
		} else if ($this->URL_MODE === 'ORIGINAL') {
			$this->_controller = isset($_GET['c']) ? trim($_GET['c']) : 'Index';
			$this->_action = isset($_GET['a']) ? trim($_GET['a']) : 'index';
		} else if ($this->URL_MODE === 'URL_REWRITE') {
			$rules = Config::Get('Rewrite');
			$url = ltrim(str_replace('\\', '/', $_SERVER['PATH_INFO']), '/');
			foreach ($rules as $regex => $route) {
				if (preg_match($regex, $url, $match)) {
					$this->_controller = $route['controller'];
					$this->_action = $route['action'];
					array_shift($match);
					$this->_params = array_combine(explode(',', $route['param']), $match);
					$_GET = $this->_params + $_GET;
					break;
				}
			}
		}
		$this->_controller = $this->_controller ? $this->_controller : $this->DEFAULT_CONTROLLER;
		$this->_action = $this->_action ? $this->_action : $this->DEFAULT_ACTION;
		defined('CONTROLLER') || define('CONTROLLER', $this->_controller . 'Action');
		defined('ACTION') || define('ACTION', $this->_action);
	}

	/**
	 * URL路由，跳转至指定控制器和行为
	 * @access public
	 * @param string $controller 控制器名
	 * @param string $action 行为名
	 * @throws BException 控制器或行为不存在
	 * @return void
	 */
	public function route($controller, $action)
	{
		if (is_file(APP_PATH . '/Action/' . $controller . '.class.php')) {
			$reflectClass = new ReflectionClass($controller);
			if ($reflectClass->hasMethod($action)) {
				$method = $reflectClass->getMethod($action);
				$method->invoke(Application::Create($controller));
			} else {
				throw new CustomException(Translate::Get('_ACTION_NOT_FOUND_') . ': ' . $controller.'->'.$action.'()', E_USER_ERROR);
			}
		} else {
			throw new CustomException(Translate::Get('_CONTROLLER_NOT_FOUND_') . ': ' . $controller, E_USER_ERROR);
		}
	}
}
