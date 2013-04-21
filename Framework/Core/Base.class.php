<?php

/**
 * 系统基类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Base
{
	/**
	 * 核心类库
	 * @access private
	 * @var array
	 */
	private static $_coreClasses = array(
		'Action' => 'Core/Action/Action.class.php',
		'Benchmark' => 'Core/Benchmark.class.php',
		'App' => 'Core/App.class.php',
		'BException' => 'Core/BException.class.php',
		'Config' => 'Core/Config.class.php',
		'DB' => 'Core/DB/DB.class.php',
		'DB_Dao' => 'Core/DB/DB_Dao.class.php',
		'DB_MySQL' => 'Core/DB/DB_MySQL.class.php',
		'DB_MySQLi' => 'Core/DB/DB_MySQLi.class.php',
		'DB_PDO' => 'Core/DB/DB_PDO.class.php',
		'FileSystem' => 'Core/FileSystem.class.php',
		'Log' => 'Core/Log.class.php',
		'Model' => 'Core/Model/Model.class.php',
		'FormModel' => 'Core/Model/FormModel.class.php',
		'RelationModel' => 'Core/Model/RelationModel.class.php',
		'Router' => 'Core/Router.class.php',
		'View' => 'Core/View/View.class.php',
		'SmartyEngine' => 'Core/View/SmartyEngine.class.php',
		'TpliteEngine' => 'Core/View/TpliteEngine.class.php',
		'NativeEngine' => 'Core/View/NativeEngine.class.php'
	);
	/**
	 * 类库注册列表
	 * @access private
	 * @var array
	 */
	private static $_regisClasses = array();
	/**
	 * 类库排除列表
	 * @access private
	 * @var array
	 */
	private static $_pushClasses = array(
		'Smarty_' => 7,
		'Smarty' => 6
	);
	/**
	 * 注册实例库
	 * @access private
	 * @var array
	 */
	private static $_instances = array();

	/**
	 * 类加载
	 * @access protected
	 * @param string $class 类名
	 * @throws BException 要载入的类不存在
	 * @return void
	 */
	protected static function ClassesLoader($class)
	{
		if (isset(self::$_coreClasses[$class])) {
			require SYS_PATH . DS . self::$_coreClasses[$class];
		} else if (isset(self::$_regisClasses[$class])) {
			require self::$_coreClasses[$class];
		} else if (substr($class, -5) === 'Model') {
			self::_ClassesRegister($class, APP_PATH . DS . 'Model/' . $class . '.class.php');
		} else if (substr($class, -6) === 'Action') {
			self::_ClassesRegister($class, APP_PATH . DS . 'Action/' . $class . '.class.php');
		} else if (self::_ClassesPusher($class)) {
			return;
		} else {
			throw new BException(Config::Lang('_CLASS_NOT_FOUND_') . ' => ' . $class);
		}
	}

	/**
	 * 类注册
	 * @access private
	 * @param string $class 类名
	 * @param string $classPath 类库路径
	 * @throws BException 要载入的类不存在
	 * @return void
	 */
	private static function _ClassesRegister($class, $classPath)
	{
		if (!is_file($classPath)) {
			throw new BException(Config::Lang('_CLASS_NOT_FOUND_') . ' => ' . $class);
		}
		if (!isset(self::$_regisClasses[$class])) {
			self::$_regisClasses[$class] = $classPath;
		}
		require self::$_regisClasses[$class];
	}

	/**
	 * 类排除
	 * @access private
	 * @param string $class 类名
	 * @return boolean true 类在排除列表 / false 类不在排除列表
	 */
	private static function _ClassesPusher($class)
	{
		foreach (self::$_pushClasses as $k => $v) {
			if (substr($class, 0, $v) === $k) {
				return true;
			}
		}
		return false;
	}

	/**
	 * 引入第三方类库，位于Extend文件夹内
	 * @access protected
	 * @param string $class 类名
	 * @throws BException 要载入的第三方类库不存在
	 * @return void
	 * @example 调用：App::Import('@Cls_Image');
	 *          应用Extend目录：/Root/YourApp/Extend/Cls_Image.php
	 * @example 调用：App::Import('Util/Paging.class');
	 *          系统Extend目录：/Root/Framework/Extend/Util/Paging.class.php
	 */
	protected static function Import($class)
	{
		if (strpos($class, '@') === 0) {
			$classpath = APP_PATH . DS . 'Extend/' . str_replace('@', '', $class) . '.php';
		} else {
			$classpath = SYS_PATH . DS . 'Extend/' . $class . '.php';
		}
		if (!is_file($classpath)) {
			throw new BException(Config::Lang('_CLASS_NOT_FOUND_') . ' => ' . $classpath);
		}
		require $classpath;
	}

	/**
	 * 创建实例，传入基类实例集并从中返回，(单例模式)
	 * @access public
	 * @param string $class 类名
	 * @param array $args 构造参数
	 * @return object 类的实例
	 */
	protected static function Create($class = __CLASS__, $args = NULL)
	{
		if (!isset(self::$_instances[$class])) {
			self::$_instances[$class] = new $class($args);
		}
		return self::$_instances[$class];
	}

	/**
	 * 构造方法，防止new实例
	 * @access private
	 * @return void
	 */
	private function __construct()
	{}

	/**
	 * 魔术方法，防止克隆实例
	 * @access private
	 * @return void
	 */
	private function __clone()
	{}

	/**
	 * 魔术方法，访问受保护参数时友好提示
	 * @access public
	 * @param string $key
	 * @throws BException 访问出错
	 * @return void
	 */
	public function __get($key)
	{
		throw new BException('Class:' . get_class($this) . '->' . $key);
	}

	/**
	 * 魔术方法，设定受保护参数时友好提示
	 * @access public
	 * @param string $key
	 * @param mixed $value
	 * @throws BException 访问出错
	 * @return void
	 */
	public function __set($key, $value)
	{
		throw new BException('Class:' . get_class($this) . '->' . $key . '=' . $value);
	}

	/**
	 * 魔术方法，设定受保护函数时友好提示
	 * @access public
	 * @param string $name 调用方法名
	 * @param mixed $args 调用参数
	 * @throws BException 访问出错
	 */
	public function __call($name, $args)
	{
		if (!method_exists($this, $name)) {
			throw new BException('Class:' . get_class($this) . '->' . $name . '()');
		}
	}
}

?>