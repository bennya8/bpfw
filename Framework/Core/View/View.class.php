<?php

/**
 * 视图中间类
 * @package Root.Framework.Core.View
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class View extends Base
{
	/**
	 * 控制器名
	 * @access private
	 * @var string
	 */
	private $_controller = '';
	
	/**
	 * 模板主题名
	 * @access private
	 * @var string
	 */
	private $_theme = '';
	
	/**
	 * 模板配置
	 * @access private
	 * @var array
	 */
	private $_viewConfig = array();
	
	/**
	 * 模板引擎实例
	 * @access private
	 * @var string
	 */
	private $_viewEngine = null;

	/**
	 * 构造方法
	 * @access protected
	 * @param array $args
	 * @return void
	 */
	protected function __construct($args)
	{
		$this->_controller = $args['controller'];
		$this->_viewConfig = Config::Conf('VIEW_CONFIG');
		$this->_viewEngine = $this->_viewFactory($this->_viewConfig['VIEW_ENGINE']);
		$this->_theme = $this->_viewConfig['VIEW_THEME'];
	}

	/**
	 * 模板引擎工厂
	 * @access public
	 * @param string $name 模板引擎名
	 * @return void
	 */
	private function _viewFactory($name)
	{
		switch (strtolower($name)) {
			case 'smarty':
				return parent::Create('SmartyEngine');
				break;
			case 'template_lite':
				return parent::Create('TpliteEngine');
				break;
			default: // 'php_native_tpl'
				return parent::Create('NativeEngine');
		}
	}

	/**
	 * 注册模板变量
	 * @access public
	 * @param string $key 变量键名
	 * @param mixed $value 变量键值
	 * @param boolean $nocache 是否缓存变量
	 * @return void
	 * @example 使用Smarty引擎，最多可传3个参数，分别：$key, $value, [$nocache]
	 * @example 使用TemplateLite引擎，可传2个参数，分别：$key, $value
	 * @example 使用原生PHP模板引擎，可传2个参数，分别：$key, $value
	 */
	public function assign($key, $value, $nocache = false)
	{
		return $this->_viewEngine->assign($key, $value, $nocache);
	}

	/**
	 * 展示模板
	 * @access public
	 * @param string $template 模板名
	 * @param int $cache_id 缓存ID
	 * @param int $compile_id 编译ID
	 * @param int $parent 父模板ID
	 * @example 使用Smarty引擎，最多可传4个参数，分别：$template, [$cache_id], [$compile_id],
	 *          [$parent]
	 * @example 使用Template Lite引擎，最多可传2个参数，分别：$template, [$cache_id]
	 * @example 使用原生PHP模板引擎，最多可传1个参数，分别：$template
	 * @return void
	 */
	public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
	{
		if (empty($template)) {
			$temp = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
			foreach ($temp as $k => $v) {
				if ($v['class'] === $this->_controller) {
					$template = $this->_theme . '/' . substr($this->_controller, 0, -6) . '/' .
							 $v['function'] . '.html';
					break;
				}
			}
		} else if (preg_match('/(\S+):(\S+)/', $template, $match)) {
			$template = $this->_theme . '/' . $match[1] . '/' . $match[2];
		} else if (preg_match('/(\S+)@(\S+):(\S+)/', $template, $match)) {
			$template = $match[1] . '/' . $match[2] . '/' . $match[3];
		} else {
			$template = $this->_theme . '/' . substr($this->_controller, 0, -6) . '/' . $template;
		}
		if (!is_file(APP_PATH . DS . 'View/' . $template)) {
			throw new BException(Config::Lang('_VIEW_NOT_FOUND_') . ' => ' . $template);
		}
		$this->_viewEngine->assign('WEBROOT', WEBROOT);
		$this->_viewEngine->display($template, $cache_id, $compile_id, $parent);
	}

	/**
	 * 跳转到成功提示页面
	 * @access public
	 * @param string $msg 提示信息
	 * @param number $time 返回时间
	 * @return void
	 */
	public function success($msg = null, $url = null, $time = 3)
	{
		$dispatch = empty($GLOBALS['Config']['SYS_CONFIG']['SYS_SUCCESS_PAGE']) ? SYS_PATH . DS .
				 'Template/systpl_page_success.html' : $GLOBALS['Config']['SYS_CONFIG']['SYS_SUCCESS_PAGE'];
		$url = empty($url) ? $_SERVER["HTTP_REFERER"] : $url;
		if (preg_match('/(\S+):(\S+)/', $dispatch, $match)) {
			$this->assign('pagelog', 
					array(
						'message' => $msg,
						'time' => $time,
						'url' => $url
					));
			$this->display($match[1] . '/' . $match[2]);
			exit();
		} else {
			$pagelog = array(
				'msg' => $msg,
				'time' => $time,
				'url' => $url
			);
			require $dispatch;
			exit();
		}
	}

	/**
	 * 跳转到错误提示页面
	 * @access public
	 * @param string $msg 提示信息
	 * @param number $time 返回时间
	 * @return void
	 */
	public function error($msg = null, $url = null, $time = 3)
	{
		$dispatch = empty($GLOBALS['Config']['SYS_CONFIG']['SYS_ERROR_PAGE']) ? SYS_PATH . DS .
				 'Template/systpl_page_error.html' : $GLOBALS['Config']['SYS_CONFIG']['SYS_ERROR_PAGE'];
		$url = empty($url) ? $_SERVER["HTTP_REFERER"] : $url;
		if (preg_match('/(\S+):(\S+)/', $dispatch, $match)) {
			$this->assign('pagelog', 
					array(
						'message' => $msg,
						'time' => $time,
						'url' => $url
					));
			$this->display($match[1] . '/' . $match[2]);
			exit();
		} else {
			$pagelog = array(
				'msg' => $msg,
				'time' => $time,
				'url' => $url
			);
			require $dispatch;
			exit();
		}
	}

	/**
	 * 弹出Alert提示框
	 * @access public
	 * @param string $msg 提示信息
	 * @return void
	 */
	public function alert($msg)
	{
		echo '<script type="text/javascript">alert("' . $msg . '"); history.back(-1);</script>';
	}

	/**
	 * 获取当前模板引擎名称
	 * @access public
	 * @return string 模板引擎名称
	 */
	public function getViewEngineName()
	{
		return $this->_viewConfig['VIEW_ENGINE'];
	}

	/**
	 * 获取当前模板引擎实例
	 * @access public
	 * @return object 模板引擎实例
	 */
	public function getViewEngine()
	{
		return $this->_viewEngine;
	}

	/**
	 * 切换模板引擎实例
	 * @param string $name 模板引擎名称
	 * @access public
	 * @return void
	 */
	public function switchViewEngine($name)
	{
		$this->_viewEngine = $this->_viewFactory($name);
	}

	/**
	 * 当调用Model内的方法不存在时，自动映射调用数据库引擎类里面方法
	 * @access public
	 * @param string $name 调用方法名
	 * @param array $args 调用参数
	 * @return mixed 调用方法的返回值
	 */
	public function __call($name, $args)
	{
		if (method_exists($this->db, $name)) {
			$reflectClass = App::Create('ReflectionClass', $this->_viewEngine);
			if ($reflectClass->hasMethod($name)) {
				$method = $reflectClass->getMethod($name);
				if ($method->isProtected() || $method->isPrivate()) {
					throw new BException(
							Config::Lang('_CALL_PRIVATE_PROTECTED_METHOD_') . ' => Class: ' .
									 get_class($this->_viewEngine) . ' Method: ' . $name . '()');
				} else {
					return $method->invokeArgs($this->_viewEngine, $args);
				}
			}
		} else {
			throw new BException(
					Config::Lang('_CALL_PRIVATE_PROTECTED_METHOD_') . ' => Class: ' .
							 get_class($this->_viewEngine) . ' Method: ' . $name . '()');
		}
	}
}
?>