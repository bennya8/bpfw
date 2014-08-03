<?php

/**
 * Database
 * @namespace System\Database
 * @package system.database.database
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Database;

use System\Core\DI;

abstract class Database
{

    /**
     * Database instance
     * @var array
     */
    private static $_instance = null;

    /**
     * Support list of database adapter
     * @var array
     */
    private static $_drivers = array(
        'mysql' => 'System\\Database\\Adapter\\MySQL',
        'mysqli' => 'System\\Database\\Adapter\\MySQLi',
        'pdo' => 'System\\Database\\Adapter\\PDO',
    );

    /**
     * Database setting
     * @var array
     */
    protected $_config = array();

    /**
     * Constructor
     * Load config set properties, and create database resource
     */
    public function __construct()
    {
        $config = DI::factory()->get('config')->get('component');
        $this->_config = $config['database'];
        $this->connect();
    }

    /**
     * Destructor
     * Free database resource
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Database factory
     * @access public
     * @param string $adapter
     * @throws \Exception
     * @return object
     */
    public static function factory($adapter = '')
    {
        if (empty($adapter)) {
            $config = DI::factory()->get('config')->get('component');
            $adapter = $config['database']['adapter'];
        }
        if (!isset(self::$_drivers[$adapter])) {
            throw new \Exception('unknown database adapter', E_ERROR);
        }
        $class = self::$_drivers[$adapter];
        if (!self::$_instance instanceof $class) {
            self::$_instance = new $class();
        }
        return self::$_instance;
    }

    /**
     * Get currently database connection identify
     * @access public
     * @return string
     */
    abstract public function getId();

    /**
     * Switch database connection with given identify. etc. master,slave1,slave2
     * @access public
     * @param string $id
     * @return void
     */
    abstract public function setId($id);

    /**
     * Open several database connection
     * @access public
     * @return bool
     */
    abstract public function connect();

    /**
     * Close several database connection
     * @access public
     * @return bool
     */
    abstract public function close();

    /**
     * Send a query sql to database
     * @access public
     * @param string $sql
     * @param array $params [optional] bind query, only available for pdo driver
     * @return mixed
     */
    abstract public function query($sql, $params = null);

    /**
     * Send an execute sql to database
     * @access public
     * @param string $sql
     * @param array $params [optional] bind query, only available for pdo driver
     * @return mixed
     */
    abstract public function execute($sql, $params = null);

    /**
     * Turn off auto submit and start a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    abstract public function begin();

    /**
     * Commit a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    abstract public function commit();

    /**
     * Rollback a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    abstract public function rollback();

    /**
     * Get last insert id
     * @access public
     * @return mixed
     */
    abstract public function lastInsertId();

    /**
     * Get last query affected rows
     * @access public
     * @return mixed
     */
    abstract public function affectedRows();

    /**
     * Show table list
     * @access public
     * @return mixed
     */
    abstract public function showTable();

    /**
     * Create a table
     * @access public
     * @return mixed
     */
    abstract public function createTable();

    /**
     * Modify a table
     * @access public
     * @return mixed
     */
    abstract public function alterTable();

    /**
     * Drop a table
     * @access public
     * @return mixed
     */
    abstract public function dropTable();

    /**
     * Rename a table
     * @access public
     * @return mixed
     */
    abstract public function renameTable();

    /**
     * Perform table optimize
     * @access public
     * @return mixed
     */
    abstract public function optimizeTable();

    /**
     * Perform table repair
     * @access public
     * @return mixed
     */
    abstract public function repairTable();

    /**
     * Get table engine
     * @access public
     * @return mixed
     */
    abstract public function getTableEngine();

    /**
     * Set table engine
     * @access public
     * @return mixed
     */
    abstract public function setTableEngine();

    /**
     * Show view list
     * @access public
     * @return mixed
     */
    abstract public function showView();

    /**
     * Create a view
     * @access public
     * @return mixed
     */
    abstract public function createView();

    /**
     * Modify a view
     * @access public
     * @return mixed
     */
    abstract public function alterView();

    /**
     * Drop a view
     * @access public
     * @return mixed
     */
    abstract public function dropView();

    /**
     * Show index list
     * @access public
     * @return mixed
     */
    abstract public function getIndex();

    /**
     * Add an index
     * @access public
     * @return mixed
     */
    abstract public function addIndex();

    /**
     * Drop an index
     * @access public
     * @return mixed
     */
    abstract public function dropIndex();

    /**
     * Get database version
     * @return mixed
     */
    abstract public function version();

}