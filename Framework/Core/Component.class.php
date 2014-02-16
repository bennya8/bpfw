<?php

/**
 * 系统组件类
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
	 * 魔术方法
	 * @access public
	 * @return void
	 */
	public function __get($key)
	{
		return isset($this->config[$key]) ? $this->config[$key] : null;
	}

	/**
	 * 魔术方法
	 * @access public
	 * @return void
	 */
	public function __set($key, $value)
	{
		return $this->config[$key] = $value;
	}

	/**
	 * 魔术方法
	 * @access public
	 * @param string $name 调用方法名
	 * @param mixed $args 调用参数
	 * @throws CustomException 访问方法不存在 / 访问受保护或私有方法 (E_WARNING)
	 */
	public function __call($name, $args)
	{
		if (method_exists($this, $name)) {
			$reflectMethod = new ReflectionMethod($this, $name);
			if ($reflectMethod->isPublic()) {
				return $reflectMethod->invoke($this);
			} else {
				throw new CustomException(
						Translate::Get('_CALL_METHOD_DENIED_') . ' => Class: ' . get_class($this) .
								 ' Method: ' . $name . '()', E_WARNING);
			}
		} else {
			throw new CustomException(
					Translate::Get('_CALL_NO_EXIST_METHOD_') . ' => Class: ' . get_class($this) .
							 ' Method: ' . $name . '()', E_WARNING);
		}
	}

	/**
	 * 魔术方法
	 * @access public
	 * @param string $name 调用方法名
	 * @param mixed $args 调用参数
	 * @throws CustomException 访问方法不存在 / 访问受保护或私有方法 (E_WARNING)
	 */
	public static function __callstatic($name, $args)
	{
		if (method_exists($this, $name)) {
			$reflectMethod = new ReflectionMethod($this, $name);
			if ($reflectMethod->isPublic()) {
				return $reflectMethod->invoke($this);
			} else {
				throw new CustomException(
						Translate::Get('_CALL_METHOD_DENIED_') . ' => Class: ' . get_class($this) .
								 ' Method: ' . $name . '()', E_WARNING);
			}
		} else {
			throw new CustomException(
					Translate::Get('_CALL_NO_EXIST_METHOD_') . ' => Class: ' . get_class($this) .
							 ' Method: ' . $name . '()', E_WARNING);
		}
	}
}