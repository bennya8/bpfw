<?php

/**
 * 系统URL路由类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Router extends Base
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
	 * URL配置
	 * @access private
	 * @var array
	 */
	private $_urlConfig = array();

	/**
	 * 构造方法
	 * @access protected
	 * @return void
	 */
	protected function __construct()
	{
		$this->_urlConfig = Config::Conf('URL_CONFIG');
	}

	/**
	 * URL分析，解析出正确URL位置
	 * @access public
	 * @return void
	 */
	public function parseUrl()
	{
		/* PATH_INFO模式 */
		if ($this->_urlConfig['URL_MODE'] === 'PATH_INFO') {
			if (!isset($_SERVER['PATH_INFO'])) {
				$this->_controller = $this->_urlConfig['DEFAULT_CONTROLLER'];
				$this->_action = $this->_urlConfig['DEFAULT_ACTION'];
			} else {
				$pathInfo = explode('/', trim(str_replace('\\', '/', $_SERVER['PATH_INFO']), '/'));
				$this->_controller = !empty($pathInfo[0]) ? $pathInfo[0] : $this->_urlConfig['DEFAULT_CONTROLLER'];
				$this->_action = !empty($pathInfo[1]) ? $pathInfo[1] : $this->_urlConfig['DEFAULT_ACTION'];
				if (!empty($pathInfo[2])) {
					$key = $value = array();
					for ($i = 2, $len = count($pathInfo); $i < $len; $i++) {
						if ($i % 2 == 0) {
							$key[] = $pathInfo[$i];
						} else {
							$value[] = $pathInfo[$i];
						}
					}
					$this->_params = array_combine($key, $value);
					$_GET = $this->_params + $_GET;
				}
			}
		} else if ($this->_urlConfig['URL_MODE'] === 'ORIGINAL') {
			$this->_controller = isset($_GET['c']) ? trim($_GET['c']) : 'Index';
			$this->_action = isset($_GET['a']) ? trim($_GET['a']) : 'index';
		} else if ($this->_urlConfig['URL_MODE'] === 'URL_REWRITE') {
			// @todo URL重写模式
		}
		$GLOBALS['CONTROLLER'] = $this->_controller . 'Action';
		$GLOBALS['ACTION'] = $this->_action;

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
		if (class_exists($controller)) {
			$reflectClass = new ReflectionClass($controller);
			if ($reflectClass->hasMethod($action)) {
				$method = $reflectClass->getMethod($action);
				$method->invoke(App::Create($controller));
			} else {
				throw new BException(Config::Lang('_ACTION_NOT_FOUND_') . ' => ' . $action);
			}
		} else {
			throw new BException(Config::Lang('_CONTROLLER_NOT_FOUND_') . ' => ' . $controller);
		}
	}
}

?>