<?php

/**
 * 系统控制器类
 * @package Root.Framework.Core.Action
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
abstract class Action extends Component
{
	/**
	 * 模板引擎实例
	 * @access protected
	 * @var object
	 */
	protected $view = null;

	/**
	 * 构造方法
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->config = Config::Get('View');
		$this->view = Application::Create('View', get_class($this));
		$this->authorize();
		$this->init();
	}

	/**
	 * 验证方法，每当创建时会自动调用，默认为空
	 */
	public function authorize()
	{}
	
	public function init(){
		
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
		$this->view->display($template, $cache_id, $compile_id, $parent);
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
		$this->view->assign($key, $value, $nocache);
	}

	/**
	 * 跳转到成功提示页面
	 * @access public
	 * @param string $message 提示信息
	 * @param string $status 提示状态
	 * @param string $url 跳转页面
	 * @param int $time 返回时间
	 * @return void
	 */
	public function message($message = null, $status = 'success', $url = null, $time = 3)
	{
		if ($status == 'success') {
			$status = Translate::Get('_OPERATION_SUCCESS_');
			$template = Config::Get('SYS_SUCCESS_PAGE');
			$template = empty($template) ? SYS_PATH . '/Template/systpl_page_success.php' : $template;
		} else {
			$status = Translate::Get('_OPERATION_ERROR_');
			$template = Config::Get('SYS_ERROR_PAGE');
			$template = empty($template) ? SYS_PATH . '/Template/systpl_page_error.php' : $template;
		}
		$url = empty($url) ? $_SERVER["HTTP_REFERER"] : $url;
		if (preg_match('/(\S+):(\S+)/', $template, $match)) {
			$this->assign('status', $status);
			$this->assign('message', $message);
			$this->assign('time', $time);
			$this->assign('url', $url);
			$this->display($match[1] . '/' . $match[2]);
		} else {
			require $template;
		}
		exit();
	}

	public function redirect($url)
	{
		header('Location: ' . WEBROOT . $url);
	}

	public function _POST($key, $default = '', $func = 'addslashes')
	{
		if (isset($_POST[$key]) && is_string($_POST[$key])) {
			return !empty($_POST[$key]) ? call_user_func($func, $_POST[$key]) : $default;
		}else if(isset($_POST[$key]) && is_array($_POST[$key]) && count($_POST[$key])){
			foreach ($_POST[$key] as $k => $v){
				if(is_string($v)){
					$_POST[$key][$k] = !empty($v) ? call_user_func($func, $v) : $default;
				}
			}
			return $_POST[$key];
		}
	}
	public function _GET($key, $default = '', $func = 'addslashes')
	{
		if (isset($_GET[$key]) && is_string($_GET[$key])) {
			return !empty($_GET[$key]) ? call_user_func($func, $_GET[$key]) : $default;
		}else if(isset($_GET[$key]) && is_array($_GET[$key]) && count($_GET[$key])){
			foreach ($_GET[$key] as $k => $v){
				if(is_string($v)){
					$_GET[$key][$k] = !empty($v) ? call_user_func($func, $v) : $default;
				}
			}
			return $_GET[$key];
		}
	}
	public function _COOKIES($key, $default = '', $func = 'addslashes')
	{
		if (isset($_COOKIE[$key]) && is_string($_COOKIE[$key])) {
			return !empty($_COOKIE[$key]) ? call_user_func($func, $_COOKIE[$key]) : $default;
		}else if(isset($_COOKIE[$key]) && is_array($_COOKIE[$key]) && count($_COOKIE[$key])){
			foreach ($_COOKIE[$key] as $k => $v){
				if(is_string($v)){
					$_COOKIE[$key][$k] = !empty($v) ? call_user_func($func, $v) : $default;
				}
			}
			return $_COOKIE[$key];
		}
	}

	public function isAjax()
	{
		$xhr = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : null;
		return empty($xhr) ? false : true;
	}
	
	/**
	 * 返回带封装格式的Json数据
	 * @access public
	 * @param string $message
	 * @param mixed $data
	 * @param int $status
	 * @return string Json数据
	 */
	public function toAjax($message = null, $data = null, $status = 1)
	{
		exit(json_encode(array(
			'message' => $message,
			'data' => $data,
			'status' => $status
		)));
	}

	/**
	 * 返回Json数据
	 * @access public
	 * @param mixed $data
	 * @return string Json数据
	 */
	public function toJson($data)
	{
		return json_encode($data);
	}

	/**
	 * 返回当前控制器名称
	 * @access public
	 * @return string 控制器名称
	 */
	public function getControllerName()
	{
		return get_class($this);
	}

	/**
	 * 获取当前模板引擎名称
	 * @access public
	 * @return string 模板引擎名称
	 */
	public function getViewEngineName()
	{
		return $this->view->getViewEngineName();
	}

	/**
	 * 获取当前模板引擎实例
	 * @access public
	 * @return object 模板引擎实例
	 */
	public function getViewEngine()
	{
		return $this->view->getViewEngine();
	}

	/**
	 * 切换模板引擎实例
	 * @param string $name 模板引擎名称
	 * @access public
	 * @return void
	 */
	public function switchViewEngine($name)
	{
		return $this->view->switchViewEngine();
	}
}

?>