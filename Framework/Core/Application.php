<?php

namespace Wiicode\Core;


class Application
{
	/**
	 * 系统注册实例库
	 * @var array
	 */
	private static $_instances = [];
	
	/**
	 * 带命名空间的类名 => 路径 映射
	 * @var unknown_type
	 */
	private static $_classMaps = [];
	private static $_aliasMaps = [];

	public function __construct() {
		self::$_classMaps = require 'CoreMaps.php';
		self::$_aliasMaps = require 'AliasMaps.php';
		spl_autoload_register([
			'System\Core\Application',
			'classLoader'
		]);
		defined('DEBUG') ? error_reporting(E_ALL) : error_reporting(0);
		Debug::start();
		Debug::trace(__METHOD__);
		$this->_initCommon();
		$this->_initComponent();
		echo Debug::end();
		return;
	}

	private function _initComponent() {
		Debug::trace(__METHOD__);
		$this->request = self::create('\System\Core\Response');
		$this->response = self::create('\System\Core\Response');
		$this->translate =  self::create('\System\i18n\Translate');
	}

	public function _initCommon() {
		Debug::trace(__METHOD__);
		$files = scandir(SYSTEM_PATH . '/common');
		foreach ($files as $realpath) {
			if ($realpath != '.' && $realpath != '..') {
				require SYSTEM_PATH . '/common/' . $realpath;
			}
		}
	}

	private function _initRoute() {
		Debug::trace(__METHOD__);
		Route::parseURL();
		Route::forward();
	}

	public static function lang() {}

	public static function create($class = __CLASS__, $args = '') {
		if (!isset(self::$_instances[$class])) {
			self::$_instances[$class] = new $class($args);
		}
		return self::$_instances[$class];
	}

	/**
	 * 类加载器
	 * @access protected
	 * @param string $class 类名
	 */
	protected static function classLoader($class) {
		if (isset(self::$_classMaps[$class])) {
			echo $class . ' => ' . SYSTEM_PATH . self::$_classMaps[$class] . ' <br>';
			require SYSTEM_PATH . self::$_classMaps[$class];
		} else if (strpos($class, '\\') !== false) {
			echo $class . ' => ' . self::getClassAlias(str_replace('\\', '.', $class)) . ' <br>';
			require self::getClassAlias(str_replace('\\', '.', $class));
		} else {
			return;
		}
	}

	protected static function getClassAlias($alias, $fileSuffix = '.php') {
		if (isset(self::$_aliasMaps[$alias])) {
			return self::$_aliasMaps[$alias];
		} else if(stripos($alias, '.') !== false) {
			$spit = stripos($alias, '.');
			switch (substr($alias, 0, $spit)) {
				case 'System':
					$aliasPrefix = SYSTEM_PATH;
					break;
				case 'Application':
					$aliasPrefix = APP_PATH;
					break;
				case 'Vendor':
					$aliasPrefix = SYSTEM_PATH . '/Vendor';
					break;
				case '@vendor':
					$aliasPrefix = APP_PATH . '/Vendor';
					break;
			}
			$aliasPath = SYSTEM_PATH . str_replace('.', '/', substr($alias, $spit)) . $fileSuffix;
			if (is_file($aliasPath)) {
				return self::setClassAlias($alias, $aliasPath);
			}
		}
		self::exception('找不到该别名' .' => '. $alias);
		return $alias;
	}

	protected static function setClassAlias($alias, $aliasPath) {
		return self::$_aliasMaps[$alias] = $aliasPath;
	}

	
	protected static function setComponent(){
		
	}
	protected static function getComponent($name){
		if(isset($this->$name)){
			return $this->$name;
		}
	}
	
	
	
	public static function exception($message, $type = null) {
		trigger_error($message);
	}

	public static function exceptionHandler(){}
	public static function errorHandler(){}
	
	
	
	public function __call($class, $args) {
		// echo $class;
		// var_dump($args);
	}

	public static function __callstatic($class, $args) {
		// echo $class;
		// var_dump($args);
	}
}

?>