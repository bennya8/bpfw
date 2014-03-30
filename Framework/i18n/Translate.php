<?php

namespace Wiicode\i18n;

use \Wiicode\Core\Component;

class Translate extends Component
{
	private static $_language = [];

	/**
	 * 加载/切换系统语言包
	 * @access public
	 * @param string $name 语言包名
	 * @throws BException 语言包丢失
	 * @return void
	 */
	public static function init($lang = 'en') {
		if (!isset(self::$_language['system'])) {
			self::$_language['system'] = require SYSTEM_PATH . '/i18n/' . $lang . '/system.php';
			if (empty(self::$_language['system'])) \System\Core\Application::exception('语言包丢失');
		}
		
		var_dump(self::$_language);
	}

	public static function get() {}

	public static function set() {}
}