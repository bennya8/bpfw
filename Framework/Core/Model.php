<?php

/**
 * Model
 * @namespace System\Core
 * @package system.core.model
 * @author Benny <benny_a8@live.com>
 * @copyright ©2014 http://github.com/bennya8
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace System\Core;

use System\Database\Criteria;

abstract class Model
{

    /**
     * Database config
     * @access private
     * @var array
     */
    private $_config;

    /**
     * Database instance
     * @access private
     * @var object
     */
    private $_db;

    /**
     * Criteria instance
     * @access private
     * @var object
     */
    private $_criteria;

    /**
     * Criteria support list of chains method
     * @access private
     * @var array
     */
    private $_criteriaChains = array('table', 'field', 'select', 'update', 'insert', 'where', 'join', 'group', 'order', 'limit');

    /**
     * Table primary key
     * @access public
     * @var string
     */
    public $pk = 'id';

    /**
     * Table prefix
     * @access public
     * @var string
     */
    public $tablePrefix = '';

    /**
     * Table full name
     * @access public
     * @var string
     */
    public $table;

    /**
     * Table columns
     * @access public
     * @var array
     */
    public $columns = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_config = DI::factory()->get('config')->get('component')['database'];
        $this->_db = DI::factory()->get('database');
        $this->_criteria = new Criteria();

        if (empty($this->table)) {
            $table = explode('\\', get_class($this));
            $table = preg_replace("/[A-Z]/", "_\\0", array_pop($table));
            $this->table = strtolower(trim($table, "_"));
            $this->tablePrefix = $this->_config['prefix'];
        }

        if (empty($this->columns)) {
            $cache = DI::factory()->get('cache');
            $cacheId = md5('tabel_' . $this->table);
            if ($this->_config['cache']) {
                $columns = $cache->get($cacheId);
                if ($columns && is_array($columns)) {
                    $this->columns = $columns;
                }
            }
            if (empty($this->columns)) {
                $columns = $this->_db->query('SHOW COLUMNS FROM ' . $this->table);
                foreach ($columns as $column) {
                    $this->columns[] = $column['Field'];
                }
                $cache->set($cacheId, $this->columns);
            }
        }
    }

    /**
     * Find a record by primary key
     * @access public
     * @param null $id
     * @return bool
     */
    public function find($id = null)
    {
        if (empty($id)) return false;
        return $this->_criteria
            ->table($this->table)
            ->where("`{$this->pk}` = '{$id}'")
            ->limit('1')
            ->select();
    }

    /**
     * Find records by column name
     * @access public
     * @param $name
     * @param $value
     * @return mixed
     */
    public function findBy($name, $value)
    {
        return $this->_criteria
            ->table($this->table)
            ->where("`{$name}` = '{$value}'")
            ->select();
    }

    /**
     * Find records with given query condition
     * @access public
     * @param array $condition
     * @return mixed
     */
    public function findAll($condition = array())
    {
        return $this->_criteria
            ->table($this->table)
            ->select($condition);
    }

    /**
     * Insert records
     * @access public
     * @param null $data
     * @return mixed
     */
    public function add($data = null)
    {
        return $this->_criteria
            ->table($this->table)
            ->insert($data);
    }

    /**
     * Update records with given where condition
     * @access public
     * @param null / array $data
     * @param null / string / array $where
     * @return mixed
     */
    public function save($data = null, $where = null)
    {
        return $this->_criteria
            ->table($this->table)
            ->update($data, $where);
    }

    /**
     * Kill records with given where condition
     * @access public
     * @param null / string / array $where
     * @return mixed
     */
    public function remove($where = null)
    {
        return $this->_criteria
            ->table($this->table)
            ->delete($where);
    }

    /**
     * Get full table name
     * @access public
     * @param null / string $name
     * @return string
     */
    public function table($name = null)
    {
        return empty($name) ? $this->tablePrefix . $this->table : $this->tablePrefix . $name;
    }

    /**
     * Switch database connection with given identify. etc. master,slave1,slave2
     * @access public
     * @param $id
     */
    public function pick($id)
    {
        $this->_db->pick($id);
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
        return $this->_db->pick($sql, $params);
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
        return $this->_db->execute($sql, $params);
    }

    /**
     * Turn off auto submit and start a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function begin()
    {
        return $this->_db->begin();
    }

    /**
     * Commit a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function commit()
    {
        return $this->_db->commit();
    }

    /**
     * Rollback a transaction, need table engine supported
     * @access public
     * @return boolean
     */
    public function rollback()
    {
        return $this->_db->rollback();
    }

    /**
     * Get last insert id
     * @access public
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->_db->lastInsertId();
    }

    /**
     * Get last query affected rows
     * @access public
     * @return mixed
     */
    public function affectedRows()
    {
        return $this->_db->affectedRows();
    }

    /**
     * Show table list
     * @access public
     * @return mixed
     */
    public function showTable()
    {
        return $this->_db->showTable();
    }

    /**
     * Create a table
     * @access public
     * @return mixed
     */
    public function createTable()
    {
        return $this->_db->createTable();
    }

    /**
     * Modify a table
     * @access public
     * @return mixed
     */
    public function alterTable()
    {
        return $this->_db->alterTable();

    }

    /**
     * Drop a table
     * @access public
     * @return mixed
     */
    public function dropTable()
    {
        return $this->_db->dropTable();
    }

    /**
     * Rename a table
     * @access public
     * @return mixed
     */
    public function renameTable()
    {
        return $this->_db->renameTable();
    }

    /**
     * Perform table optimize
     * @access public
     * @return mixed
     */
    public function optimizeTable()
    {
        return $this->_db->optimizeTable();
    }

    /**
     * Perform table repair
     * @access public
     * @return mixed
     */
    public function repairTable()
    {
        return $this->_db->repairTable();
    }

    /**
     * Get table engine
     * @access public
     * @return mixed
     */
    public function getTableEngine()
    {
        return $this->_db->getTableEngine();
    }

    /**
     * Set table engine
     * @access public
     * @return mixed
     */
    public function setTableEngine()
    {
        return $this->_db->setTableEngine();
    }

    /**
     * Show view list
     * @access public
     * @return mixed
     */
    public function showView()
    {
        return $this->_db->showView();
    }

    /**
     * Create a view
     * @access public
     * @return mixed
     */
    public function createView()
    {
        return $this->_db->createView();
    }

    /**
     * Modify a view
     * @access public
     * @return mixed
     */
    public function alterView()
    {
        return $this->_db->alterView();
    }

    /**
     * Drop a view
     * @access public
     * @return mixed
     */
    public function dropView()
    {
        return $this->_db->dropView();

    }

    /**
     * Show index list
     * @access public
     * @return mixed
     */
    public function showIndex()
    {
        return $this->_db->getIndex();
    }

    /**
     * Add an index
     * @access public
     * @return mixed
     */
    public function addIndex()
    {
        return $this->_db->addIndex();
    }

    /**
     * Drop an index
     * @access public
     * @return mixed
     */
    public function dropIndex()
    {
        return $this->_db->dropIndex();
    }

    /**
     * Invoke method
     * @access public
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args = array())
    {
        if (in_array($method, $this->_criteriaChains)) {
            if (isset($args[0])) {
                $this->_criteria->setCondition($method, $args[0]);
            }
            return $this;
        } elseif (substr($method, 0, 6) === 'findBy') {
            $method = ltrim(strtolower(preg_replace("/[A-Z]/", "_\\0", substr($method, 6))), '_');
            if (isset($args[0]) && in_array($method, $this->columns)) {
                return $this->findBy($method, $args[0]);
            } else {
                return false;
            }
        }
    }

}
