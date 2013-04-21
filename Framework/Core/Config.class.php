<?php

/**
 * 系统配置读写类
 * @package Root.Framework.Core
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Config extends Base
{

	/**
	 * 加载/切换系统语言包，语言包位置：/Framework/Lang
	 * @access public
	 * @param string $name 语言包名
	 * @throws BException 语言包丢失
	 * @return void
	 */
	public function loadLanguage($name = 'ZH-CN')
	{
		if (!isset($GLOBALS['Lang'])) {
			$sysLang = SYS_PATH . DS . 'Lang/' . $name . '.php';
			if (!is_file($sysLang)) throw new BException('_LANG_FILE_MISSING_ => ' . securePath($sysLang));
			$GLOBALS['Lang'] = require $sysLang;
		}
	}

	/**
	 * 读取系统配置
	 * @access public
	 * @throws BException 系统配置文件丢失
	 * @return void
	 */
	public function loadConfig()
	{
		if (!isset($GLOBALS['Config'])) {
			$app_conf = APP_PATH . DS . 'Conf/conf.php';
			$sys_conf = SYS_PATH . DS . 'Core/Conf/conf.php';
			if (!is_file($sys_conf)) throw new BException('_APPCONF_FILE_MISSING_ => ' . securePath($sys_conf));
			if (is_file($app_conf)) {
				$app_conf = require $app_conf;
				$sys_conf = require $sys_conf;
				$GLOBALS['Config'] = multi_array_merge($sys_conf,$app_conf);
			} else {
				$sys_conf = require $sys_conf;
				$GLOBALS['Config'] = $sys_conf;
			}
		}
	}

	/**
	 * 读取系统语言
	 * @access public
	 * @param string $key
	 * @return string / null
	 */
	public static function Lang($key)
	{
		return array_key_exists($key, $GLOBALS['Lang']) ? $GLOBALS['Lang'][$key] : null;
	}

	/**
	 * 读取 / 写入系统配置，只传入$key时为读取参数，同时传入$key,$value为设定参数
	 * @access public
	 * @param string $key 参数名
	 * @param string $value 参数值
	 * @return string / null
	 */
	public static function Conf($key = null, $value = null)
	{
		if (!empty($key) && !empty($value)) {
			$GLOBALS['Config'][$key] = $value;
		} elseif (!empty($key)) {
			return array_key_exists($key, $GLOBALS['Config']) ? $GLOBALS['Config'][$key] : null;
		}
		return null;
	}
}
?>