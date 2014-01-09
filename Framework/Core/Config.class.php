<?php

/**
 * 系统配置读写类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Config
{
	/**
	 * 配置信息
	 * @var unknown
	 */
	private static $_config = array();

	/**
	 * 读取系统配置
	 * @access public
	 * @throws BException 系统配置文件丢失
	 * @return void
	 */
	public static function Init()
	{
		if (empty(self::$_config)) {
			$sysConfig = SYS_PATH . '/Core/Config/config.php';
			$appConfig = APP_PATH . '/Config/config.php';
			if (!is_file($sysConfig)) Application::TriggerError('_SYSCONF_FILE_MISSING_ => ' . securePath($sysConfig), 'error');
			if (!is_file($appConfig)) Application::TriggerError('_APPCONF_FILE_MISSING_ => ' . securePath($appConfig), 'error');
			$sysConfig = require $sysConfig;
			$appConfig = require $appConfig;
			self::$_config = array_merge($sysConfig, $appConfig);
		}
	}

	/**
	 * 读取配置值
	 * @access public
	 * @param string $key
	 * @return string / null
	 */
	public static function Get($key)
	{
		return isset(self::$_config[$key]) ? self::$_config[$key] : null;
	}

	/**
	 * 写入配置键值
	 * @access public
	 * @param string $key
	 * @param string $value
	 * @return string / null
	 */
	public static function Set($key, $value)
	{
		return self::$_config[$key] = $value;
	}
}