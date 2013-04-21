<?php

/**
 * 系统控制器类
 * @package Root.Framework.Core.Action
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Action extends Base
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
		$config = Config::Conf('VIEW_CONFIG');
		$args['controller'] = $this->getControllerName();
		$this->view = View::Create('View', $args);
		$this->authorize();
	}

	/**
	 * 验证方法，每当创建时会自动调用，默认为空
	 */
	public function authorize()
	{}

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
	 * @param string $msg 提示信息
	 * @param string $url 跳转URL
	 * @param number $time 跳转时间
	 * @return void
	 */
	public function success($msg = null,$url = null, $time = 3)
	{
		$this->view->success($msg,$url, $time);
	}

	/**
	 * 跳转到错误提示页面
	 * @access public
	 * @param string $msg 提示信息
	 * @param string $url 跳转URL
	 * @param number $time 跳转时间
	 * @return void
	 */
	public function error($msg = null, $url = null ,$time= 3)
	{
		$this->view->error($msg,$url, $time);
	}

	/**
	 * 弹出Alert提示框
	 * @access public
	 * @param string $msg 提示信息
	 * @return void
	 */
	public function alert($msg)
	{
		$this->view->alert($msg);
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