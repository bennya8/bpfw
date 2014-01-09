<?php

/**
 * 系统自定义异常类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
abstract class Component
{
	protected $config = array();

	/**
	 * 构造方法
	 * @access protected
	 * @return void
	 */
	public function __construct()
	{
		$this->config = Config::Get(get_class($this));
	}

	/**
	 * 魔术方法，设定受保护函数时防止发生终止错误，只在开发模式抛出异常
	 * @access public
	 * @return void
	 */
	public function __get($key)
	{
		if (isset($this->config[$key])) {
			return $this->config[$key];
		} else if (property_exists($this, $key)) {
			$property = new ReflectionProperty($this, $key);
			if ($property->isPublic()) {
				return $this->$key;
			} else {
				Application::TriggerError(Translate::Get('_PROPERTY_ACCESS_DENIED') . ' => Class: ' . get_class($this) . ' Propertiy: ' . $key, 'notice');
			}
		} else {
			Application::TriggerError(Translate::Get('_GET_PROPERTY_DENIED_') . ' => Class: ' . get_class($this) . ' Propertiy: ' . $key, 'notice');
		}
	}

	/**
	 * 魔术方法，设定受保护函数防止发生终止错误，只在开发模式抛出异常
	 * @access public
	 * @return void
	 */
	public function __set($key, $value)
	{

	}

	/**
	 * 魔术方法，设定受保护函数防止发生终止错误
	 * 调用不存在函数时尝试抛出错误信息，顶层捕获后，
	 * 根据环境需要作出是否显示或记录日志
	 * @access public
	 * @param string $name 调用方法名
	 * @param mixed $args 调用参数
	 * @throws BException 访问出错
	 */
	// public function __call($name, $args) {
	// echo 1;
	// if (!method_exists($this, $name)) {
	// Application::TriggerError(
	// Translate::Get('_CALL_METHOD_DENIED_') . ' => Class: ' . get_class($this)
	// . ' Method: ' . $name .
	// '()', 'warning');
	// }
	// }
	
	/**
	 * 魔术方法，设定受保护函数防止发生终止错误
	 * 调用不存在函数时尝试抛出错误信息，顶层捕获后，
	 * 根据环境需要作出是否显示或记录日志
	 * @access public
	 * @param string $name 调用方法名
	 * @param mixed $args 调用参数
	 * @throws BException 访问出错
	 */
	public static function __callstatic($name, $args)
	{
		if (property_exists($this, $key)) {
			$reflectMethod = new ReflectionProperty($this, $key);
			if ($reflectMethod->isPublic()) {
				return $this->$key;
			} else {
				Application::TriggerError(Translate::Get('_PROPERTY_ACCESS_DENIED') . ' => Class: ' . get_class($this) . ' Propertiy: ' . $key, 'notice');
			}
		} else {
			Application::TriggerError(Translate::Get('_GET_PROPERTY_DENIED_') . ' => Class: ' . get_class($this) . ' Propertiy: ' . $key, 'notice');
		}
		if (!method_exists($this, $name)) {
			Application::TriggerError(
					Translate::Get('_CALL_STATIC_METHOD_DENIED_') . ' => Class: ' . get_class($this) . ' Static Method: ' . $name . '()', 'warning');
		}
	}
}