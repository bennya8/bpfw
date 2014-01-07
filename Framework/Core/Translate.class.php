<?php

/**
 * 系统语言翻译类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Translate
{
	/**
	 * 语言包信息
	 * @var array
	 */
	private static $_language = array();
	/**
	 * 当前语言环境
	 * @var string
	 */
	private static $_current = '';

	/**
	 * 加载/切换系统语言包
	 * @access public
	 * @param string $name 语言包名
	 * @throws BException 语言包丢失
	 * @return void
	 */
	public static function Init($lang = 'ZH-CN') {
		if (!isset(self::$_language[$lang])) {
			$path = SYS_PATH . '/Lang/' . strtoupper($lang) . '.php';
			if (!is_file($path)) Application::TriggerError('_LANG_FILE_MISSING_ => ' . securePath($path), 'error');
			self::$_language[$lang] = require $path;
			self::$_current = $lang;
		}
	}

	/**
	 * 读取语言值
	 * @access public
	 * @param string $key
	 * @return string / null
	 */
	public static function Get($key) {
		return isset(self::$_language[self::$_current][$key]) ? self::$_language[self::$_current][$key] : null;
	}

	/**
	 * 写入语言键值
	 * @access public
	 * @param string $key
	 * @param string $value
	 * @return string / null
	 */
	public static function Set($key, $value) {
		return self::$_language[self::$_current][$key] = $value;
	}
}