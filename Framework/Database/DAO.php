<?php

namespace Wiicode\Database;

/**
 * DAO 实现类
 * @namespace System\Database
 * @package system.database
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class DAO
{
	
	private static $_instance = null;
	private static $_dbDriver = array(
		'odbc:access' => 'AccessHelper',
		'mysql' => 'MySQLHelper',
		'mysqli' => 'MySQLiHelper',
		'pdo:mysql' => 'PDOHelper',
		'pdo:oracle' => 'PDOHelper',
		'pdo:mssql' => 'PDOHelper',
		'pdo:sqlite' => 'PDOHelper'
	);

	public static function factory($dsn)
	{
		if (isset(self::$_dbDriver[$dsn])) {
			self::$_instance = Web::create(self::$_dbDriver[$dsn]);
		}
		return self::$_instance;
	}

	private function __construct()
	{}

	public function __clone()
	{
		return self::$_instance;
	}
}

?>