<?php

/**
 * MySQL Adapter
 * @namespace System\Database
 * @package system.database.adapter.mysql
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013-2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Database\Adapter;

use System\Core\DI;
use System\Database\Database;

class MySQL extends Database
{
    /**
     * Database servers instance
     * @var array
     */
    private $_servers = array();

    /**
     * Instance id selector
     * @var string
     */
    private $_id = '';

    /**
     * Switch database instance by using id selector
     * @param string $id
     */
    public function pick($id = '')
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
        if (!function_exists('mysql_connect')) {
            throw new \Exception('mysql module not install', E_ERROR);
        }
        $ids = array_keys($servers);
        if (empty($ids)) {
            throw new \Exception('fail to load server config', E_ERROR);
        } else {
            $this->_id = $ids[0];
        }
        foreach ($servers as $id => $cfg) {
            if (!isset($this->_servers[$id])) {
                $resource = mysql_connect($cfg['host'] . ':' . $cfg['port'], $cfg['username'], $cfg['password']);
                mysql_select_db($cfg['database'], $resource);
                mysql_query("set charset = {$cfg['charset']}", $resource);
                $this->_servers[$id] = $resource;
            }
        }
    }

    /**
     * Close several database connection
     * @access public
     * @return bool
     */
    public function close()
    {
        foreach ($this->_servers as $id => $resource) {
            mysql_close($resource);
            unset($this->_servers[$id]);
        }
    }

    /**
     * Send a query sql to database
     * @access public
     * @param string $sql
     * @param array $params [optional] bind query, only available for pdo driver
     * @throws \Exception
     * @return mixed
     */
    public function query($sql, $params = null)
    {
        $rows = array();
        $result = mysql_query($sql, $this->_servers[$this->_id]);
        if (!$result) {
            throw new \Exception(mysql_error($this->_servers[$this->_id]));
        }
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Send an execute sql to database
     * @access public
     * @param string $sql
     * @param array $params [optional] bind query, only available for pdo driver
     * @throws \Exception
     * @return mixed
     */
    public function execute($sql, $params = null)
    {
        $result = mysql_query($sql, $this->_servers[$this->_id]);
        if (!$result) {
            throw new \Exception(mysql_error($this->_servers[$this->_id]));
        }
        return mysql_affected_rows($this->_servers[$this->_id]);
    }

    /**
     * Turn off auto submit and start a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function begin()
    {
        mysql_query('BEGIN', $this->_servers[$this->_id]);
    }

    /**
     * Commit a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function commit()
    {
        mysql_query('COMMIT', $this->_servers[$this->_id]);
        mysql_query('END', $this->_servers[$this->_id]);
    }

    /**
     * Rollback a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function rollback()
    {
        mysql_query('ROLLBACK', $this->_servers[$this->_id]);
        mysql_query('END', $this->_servers[$this->_id]);
    }

    /**
     * Get last insert id
     * @access public
     * @return mixed
     */
    public function lastInsertId()
    {
        mysql_insert_id($this->_servers[$this->_id]);
    }

    /**
     * Get last query affected rows
     * @access public
     * @return mixed
     */
    public function affectedRows()
    {
        mysql_affected_rows($this->_servers[$this->_id]);
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


    public function dropIndex()
    {
//        ALTER TABLE `dingmore_www`.`www_user`
//DROP INDEX `222` ;
    }

    public function version()
    {
        $version = $this->query('select VERSION() as version');
        return isset($version[0]['version']) ? $version[0]['version'] : 'unknown';
    }


}