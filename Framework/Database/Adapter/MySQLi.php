<?php

/**
 * MySQLi Adapter
 * @namespace System\Database
 * @package system.database.adapter.mysql
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Database\Adapter;

use System\Database\Database;

class MySQLi extends Database
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
     * Get currently database connection identify
     * @access public
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set database connection with given identify. etc. master,slave1,slave2
     * @access public
     * @param string $id
     * @return void
     */
    public function setId($id)
    {
        if (is_string($id) && array_key_exists($id, $this->_servers)) {
            $this->_id = $id;
        }
    }

    /**
     * Open several database connection
     * @access public
     * @throws \Exception
     * @return bool
     */
    public function connect()
    {
        if (!function_exists('mysqli_connect')) {
            throw new \Exception('mysqli module not install', E_ERROR);
        }
        $ids = array_keys($this->_config['servers']);
        if (empty($ids)) {
            throw new \Exception('fail to load server config', E_ERROR);
        } else {
            $this->_id = $ids[0];
        }
        foreach ($this->_config['servers'] as $id => $cfg) {
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
        foreach ($this->_servers as $id => $resource) {
            $resource->close();
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
        $stmt = $this->_servers[$this->_id]->prepare($sql);
        $result = $stmt->execute();
        if (!$result) {
            throw new \Exception('query sql: ' . $sql, E_ERROR);
        }
        $list = array();
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                $list[] = $row;
            }
        }
        $result->free();
        $result->close();
        return $list;
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
        $stmt = $this->_servers[$this->_id]->prepare($sql);
        $result = $stmt->execute();
        if (!$result) {
            throw new \Exception('execute sql: ' . $sql, E_ERROR);
        }
        $result->free();
        $result->close();
        return $this->_servers[$this->_id]->affected_rows;
    }

    /**
     * Turn off auto submit and start a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function begin()
    {
        return $this->_servers[$this->_id]->autocommit(false);
    }

    /**
     * Commit a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function commit()
    {
        return $this->_servers[$this->_id]->commit();
    }

    /**
     * Rollback a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function rollback()
    {
        return $this->_servers[$this->_id]->rollback();
    }

    /**
     * Get last insert id
     * @access public
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->_servers[$this->_id]->insert_id;
    }

    /**
     * Get last query affected rows
     * @access public
     * @return mixed
     */
    public function affectedRows()
    {
        return $this->_servers[$this->_id]->affected_rows;
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
        $version = $this->query('select VERSION() as version');
        return isset($version[0]['version']) ? $version[0]['version'] : 'unknown';
    }

}