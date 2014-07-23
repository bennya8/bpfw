<?php

/**
 * MySQLi Adapter
 * @namespace System\Database
 * @package system.database.adapter.mysql
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Database\Adapter;

use System\Core\DI;
use System\Database\Database;

class MySQLi extends Database
{
    /**
     * Database instances container
     * @var array
     */
    private $_servers = array();

    /**
     * Database resource
     * @var object
     */
    private $_id = '';

    /**
     * Switch database connection with given identify. etc. master,slave1,slave2
     * @access public
     * @param $id
     * @return void
     */
    public function pick($id)
    {
        $this->_id = $id;
    }

    /**
     * Open several database connection
     * @access public
     * @throws \Exception
     * @return bool
     */
    public function connect()
    {
        $config = DI::factory()->get('config')->get('component');
        $servers = $config['database']['servers'];
        if (!function_exists('mysqli_connect')) {
            throw new \Exception('mysqli module not install', E_ERROR);
        }
        $ids = array_keys($servers);
        if (empty($ids)) {
            throw new \Exception('fail to load server config', E_ERROR);
        } else {
            $this->_id = $ids[0];
        }
        foreach ($servers as $id => $cfg) {
            if (!isset($this->_servers[$id])) {
                $resource = new \mysqli($cfg['host'], $cfg['username'], $cfg['password'], $cfg['database'], $cfg['port']);
                $resource->select_db($cfg['database']);
                $resource->set_charset($cfg['charset']);
                $this->_servers[$id] = $resource;
            }
        }
    }

    /**
     * Close several database connection
     * @return mixed
     */
    public function close()
    {
        // TODO: Implement close() method.
    }

    /**
     * Send a query sql to database
     * @access public
     * @param string $sql
     * @param array $params [optional] bind query, only available for pdo driver
     * @return mixed
     */
    public function query($sql, $params = null)
    {
        // TODO: Implement query() method.
    }

    /**
     * Send an execute sql to database
     * @access public
     * @param string $sql
     * @param array $params [optional] bind query, only available for pdo driver
     * @return mixed
     */
    public function execute($sql, $params = null)
    {
        // TODO: Implement execute() method.
    }

    /**
     * Turn off auto submit and start a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function begin()
    {
        // TODO: Implement begin() method.
    }

    /**
     * Commit a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function commit()
    {
        // TODO: Implement commit() method.
    }

    /**
     * Rollback a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function rollback()
    {
        // TODO: Implement rollback() method.
    }

    /**
     * Get last insert id
     * @access public
     * @return mixed
     */
    public function lastInsertId()
    {
        // TODO: Implement lastInsertId() method.
    }

    /**
     * Get last query affected rows
     * @access public
     * @return mixed
     */
    public function affectedRows()
    {
        // TODO: Implement affectedRows() method.
    }

    /**
     * Show table list
     * @access public
     * @return mixed
     */
    public function showTable()
    {
        // TODO: Implement showTable() method.
    }

    /**
     * Create a table
     * @access public
     * @return mixed
     */
    public function createTable()
    {
        // TODO: Implement createTable() method.
    }

    /**
     * Modify a table
     * @access public
     * @return mixed
     */
    public function alterTable()
    {
        // TODO: Implement alterTable() method.
    }

    /**
     * Drop a table
     * @access public
     * @return mixed
     */
    public function dropTable()
    {
        // TODO: Implement dropTable() method.
    }

    /**
     * Rename a table
     * @access public
     * @return mixed
     */
    public function renameTable()
    {
        // TODO: Implement renameTable() method.
    }

    /**
     * Perform table optimize
     * @access public
     * @return mixed
     */
    public function optimizeTable()
    {
        // TODO: Implement optimizeTable() method.
    }

    /**
     * Perform table repair
     * @access public
     * @return mixed
     */
    public function repairTable()
    {
        // TODO: Implement repairTable() method.
    }

    /**
     * Get table engine
     * @access public
     * @return mixed
     */
    public function getTableEngine()
    {
        // TODO: Implement getTableEngine() method.
    }

    /**
     * Set table engine
     * @access public
     * @return mixed
     */
    public function setTableEngine()
    {
        // TODO: Implement setTableEngine() method.
    }

    /**
     * Show view list
     * @access public
     * @return mixed
     */
    public function showView()
    {
        // TODO: Implement showView() method.
    }

    /**
     * Create a view
     * @access public
     * @return mixed
     */
    public function createView()
    {
        // TODO: Implement createView() method.
    }

    /**
     * Modify a view
     * @access public
     * @return mixed
     */
    public function alterView()
    {
        // TODO: Implement alterView() method.
    }

    /**
     * Drop a view
     * @access public
     * @return mixed
     */
    public function dropView()
    {
        // TODO: Implement dropView() method.
    }

    /**
     * Show index list
     * @access public
     * @return mixed
     */
    public function getIndex()
    {
        // TODO: Implement getIndex() method.
    }

    /**
     * Add an index
     * @access public
     * @return mixed
     */
    public function addIndex()
    {
        // TODO: Implement addIndex() method.
    }

    /**
     * Drop an index
     * @access public
     * @return mixed
     */
    public function dropIndex()
    {
        // TODO: Implement dropIndex() method.
    }

    /**
     * Get database version
     * @return mixed
     */
    public function version()
    {
        // TODO: Implement version() method.
    }


}