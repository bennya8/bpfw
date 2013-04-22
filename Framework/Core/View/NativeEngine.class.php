<?php

/**
 * PHP原生引擎实现类
 * @package Root.Framework.Core.View
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class NativeEngine
{
	/**
	 * 模板路径
	 * @access private
	 * @var string
	 */
	private $_templateDir = '';
	/**
	 * 模板变量储存
	 * @access private
	 * @var array
	 */
	private $_vars = array();

	/**
	 * 构造方法，初始化配置
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->_templateDir = APP_PATH . DS . 'View/';
	}

	/**
	 * 模板展示
	 * @access public
	 * @param string $template 模板名
	 * @return void
	 */
	public function display($template)
	{
		extract($this->_vars);
		require $this->_templateDir . $template;
	}

	/**
	 * 模板变量注册
	 * @access public
	 * @param string $key 模板变量名
	 * @param mixed $value 模板变量值
	 * @return void
	 */
	public function assign($key, $value)
	{
		$this->_vars[$key] = $value;
	}
}

?>