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
		'Action' => '/Core/Action/Action.class.php',
		'Benchmark' => '/Core/Benchmark.class.php',
		'Application' => '/Core/Application.class.php',
		'Component' => '/Core/Component.class.php',
		'CustomException' => '/Core/CustomException.class.php',
		'Config' => '/Core/Config.class.php',
		'Translate' => '/Core/Translate.class.php',
		'Database' => '/Core/Database/Database.class.php',
		'Database_Dao' => '/Core/Database/Database_Dao.class.php',
		'Database_MySQL' => '/Core/Database/Database_MySQL.class.php',
		'Database_MySQLi' => '/Core/Database/Database_MySQLi.class.php',
		'Database_PDO' => '/Core/Database/Database_PDO.class.php',
		'FileSystem' => '/Core/FileSystem.class.php',
		'Log' => '/Core/Log.class.php',
		'Model' => '/Core/Model/Model.class.php',
		'FormModel' => '/Core/Model/FormModel.class.php',
		'Router' => '/Core/Router.class.php',
		'View' => '/Core/View/View.class.php',
		'SmartyEngine' => '/Core/View/SmartyEngine.class.php',
		'TpliteEngine' => '/Core/View/TpliteEngine.class.php',
		'NativeEngine' => '/Core/View/NativeEngine.class.php'
	);
	
	/**
	 * 类库注册列表
	 * @access private
	 * @var array
	 */
	private static $_regisClasses = array();
	
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
	protected static function ClassesLoader($class) {
		if (isset(self::$_coreClasses[$class])) {
			require SYS_PATH . self::$_coreClasses[$class];
		} else if (isset(self::$_regisClasses[$class])) {
			require self::$_coreClasses[$class];
		} else if (substr($class, -5) === 'Model') {
			self::_ClassesRegister($class, APP_PATH . '/Model/' . $class . '.class.php');
		} else if (substr($class, -6) === 'Action') {
			self::_ClassesRegister($class, APP_PATH . '/Action/' . $class . '.class.php');
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
	private static function _ClassesRegister($class, $classPath) {
		if (!isset(self::$_regisClasses[$class])) {
			self::$_regisClasses[$class] = $classPath;
		}
		require self::$_regisClasses[$class];
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
	protected static function Import($class) {
		if (strpos($class, '@') === 0) {
			$classpath = APP_PATH . DS . 'Extend/' . str_replace('@', '', $class) . '.php';
		} else {
			$classpath = SYS_PATH . DS . 'Extend/' . $class . '.php';
		}
		if (!is_file($classpath)) {
			Application::TriggerError(Translate::Get('_CLASS_NOT_FOUND_') . ' => ' . $classpath, 'error');
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
	protected static function Create($class = __CLASS__, $args = NULL) {
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
	private function __construct() {}

	/**
	 * 魔术方法，防止克隆实例
	 * @access private
	 * @return void
	 */
	private function __clone() {}
}