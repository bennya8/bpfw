<?php

/**
 * 数据库中间类
 * @package Root.Framework.Core.DB
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class DB extends Base
{
	/**
	 * 数据库工厂，(单例模式)
	 * @access public
	 * @param string $name 类名
	 * @return object 数据库实例
	 */
	public static function Factory($name)
	{
		switch ($name) {
			case 'MySQLi':
				return parent::Create('DB_MySQLi');
				break;
			case 'PDO:MySQL':
				return parent::Create('DB_PDO_MySQL');
				break;
			case 'PDO:SQLite':
				return parent::Create('DB_PDO_SQLite');
				break;
			case 'PDO:Oracle':
				return parent::Create('DB_PDO_Oracle');
				break;
			default:
				return parent::Create('DB_MySQL');
		}
	}

	/**
	 * 获取当前数据库引擎名
	 * @access public
	 * @return object 实例
	 */
	public function getDbEngineName()
	{
		return get_class($this);
	}

	/**
	 * 获取当前数据库引擎实例
	 * @access public
	 * @return object 实例
	 */
	public function getDbEngine()
	{
		return $this;
	}
}
?>