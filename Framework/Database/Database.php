<?php

/**
 * Database implementation
 * @namespace System\Database
 * @package system.database
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Database;

abstract class Database implements IResult, IUtilities
{

    private static $_instance = null;

    private static $_criteria = null;

    private static $_defaultDriver = 'mysql';

    private static $_drivers = array(
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
            $dsn = array_key_exists($dsn, self::$_drivers) ? self::$_dbDriver[$dsn] : 'mysql';
            self::$_instance = Web::create($dsn);
        }
        return self::$_instance;
    }

    private function __construct()
    {
    }

    public function __clone()
    {
    }
}