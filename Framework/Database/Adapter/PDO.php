<?php

/**
 * PDO Adapter
 * @namespace System\Database
 * @package system.database.adapter.mysql
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Database\Adapter;

use System\Database\Database;

class PDO extends Database
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
     * Get last query affected rows
     * @var int
     */
    private $_affectedRows = -1;

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
        if (!in_array('mysql', pdo_drivers())) {
            throw new \Exception('pdo mysql module not install', E_ERROR);
        }
        $ids = array_keys($this->_config['servers']);
        if (empty($ids)) {
            throw new \Exception('fail to load server config', E_ERROR);
        } else {
            $this->_id = $ids[0];
        }
        foreach ($this->_config['servers'] as $id => $cfg) {
            if (!isset($this->_servers[$id])) {
                $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . $cfg['charset'];
                $this->_servers[$id] = new \PDO("mysql:host={$cfg['host']};port={$cfg['port']};dbname={$cfg['database']}",
                    $cfg['username'], $cfg['password'], $options);
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
        if (!empty($params) && is_array($params)) {
            $result = $stmt->execute($params);
        } else {
            $result = $stmt->execute();
        }
        if (!$result) {
            throw new \Exception('query sql: ' . $sql, E_ERROR);
        }
        $this->_affectedRows = $stmt->rowCount();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        if (!empty($params) && is_array($params)) {
            $result = $stmt->execute($params);
        } else {
            $result = $stmt->execute();
        }
        if (!$result) {
            throw new \Exception('execute sql: ' . $sql, E_ERROR);
        }
        return $this->_affectedRows = $stmt->rowCount();
    }

    /**
     * Turn off auto submit and start a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function begin()
    {
        return $this->_servers[$this->_id]->beginTransaction();
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
        return $this->_servers[$this->_id]->rollBack();
    }

    /**
     * Get last insert id
     * @access public
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->_servers[$this->_id]->lastInsertId();
    }

    /**
     * Get last query affected rows
     * @access public
     * @return mixed
     */
    public function affectedRows()
    {
        return $this->_affectedRows;
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
     * @param string $tableName
     * @param string $newTableName
     * @return mixed
     */
    public function dropTable($tableName, $newTableName)
    {
        // TODO: Implement dropTable() method.
    }

    /**
     * Perform table optimize
     * @access public
     * @param string $tableName
     * @return mixed
     */
    public function optimizeTable($tableName)
    {
        // TODO: Implement optimizeTable() method.
    }

    /**
     * Perform table repair
     * @access public
     * @param string $tableName
     * @return mixed
     */
    public function repairTable($tableName)
    {
        // TODO: Implement repairTable() method.
    }

    /**
     * Get table engine
     * @access public
     * @param string $tableName
     * @return mixed
     */
    public function getTableEngine($tableName)
    {
        // TODO: Implement getTableEngine() method.
    }

    /**
     * Set table engine
     * @access public
     * @param string $tableName
     * @param string $engineName
     * @return mixed
     */
    public function setTableEngine($tableName, $engineName)
    {
        // TODO: Implement setTableEngine() method.
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