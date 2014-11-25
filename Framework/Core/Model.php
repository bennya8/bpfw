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
     * Validate when field not empty
     */
    const FIELD_NOT_EMPTY = 0;

    /**
     * Validate when field is set
     */
    const FIELD_ISSET = 1;

    /**
     * Validate when field not empty and is set
     */
    const FIELD_BOTH = 2;

    /**
     * Validate field value from GET query
     */
    const INPUT_GET = 'get';

    /**
     * Validate field value from POST params
     */
    const INPUT_POST = 'post';

    /**
     * Validate field value from PUT params
     */
    const INPUT_PUT = 'put';

    /**
     * Validate field value from DELETE params
     */
    const INPUT_DELETE = 'delete';

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
     * Validation instance
     * @access private
     * @var object
     */
    private $_validation;

    /**
     * Valid data
     * @var array
     */
    private $_data = array();

    /**
     * Error message
     * @access private
     * @var string
     */
    private $_error = array();

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
     * Validate rules
     * @public
     * @var array
     */
    public $rules = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $config = DI::factory()->get('config')->get('component');
        $this->_config = $config['database'];
        $this->_db = DI::factory()->get('database');
        $this->_criteria = new Criteria();
        $this->_validation = new Validation();

        $this->tablePrefix = $this->_config['prefix'];
        if (empty($this->table)) {
            $table = explode('\\', get_class($this));
            $table = preg_replace("/[A-Z]/", "_\\0", array_pop($table));
            $this->table = strtolower(trim($table, "_"));
        }

        if (empty($this->columns)) {
            $cache = DI::factory()->get('cache');
            if (is_object($cache) && $this->_config['cache']) {
                $cache_id = md5('tabel_' . $this->table);
                if ($this->_config['cache']) {
                    $columns = $cache->get($cache_id);
                    if ($columns && is_array($columns)) {
                        $this->columns = $columns;
                    }
                }
            }
            if (empty($this->columns)) {
                $columns = $this->_db->query('SHOW COLUMNS FROM ' . $this->tableName());
                foreach ($columns as $column) {
                    $this->columns[] = $column['Field'];
                }
                if (is_object($cache) && $this->_config['cache']) {
                    $cache->set($cache_id, $this->columns);
                }
            }
        }
    }

    /**
     * Get rule by given event key and rules
     * @param $on
     * @return null
     */
    public function getRules($on)
    {
        return isset($this->rules[$on]) ? $this->rules[$on] : false;
    }

    /**
     * Set rule by given event key and rules
     * @param $on
     * @param $rules
     */
    public function setRules($on, $rules)
    {
        if (is_array($rules)) {
            $this->rules[$on] = $rules;
        }
    }

    public function create($on)
    {
        return $this->validateRules($on, true);
    }

    /**
     * Run specified rule
     * @param $on
     * @param bool $isField
     * @return array|bool
     */
    public function validateRules($on, $isField = false)
    {
        if (!$rules = $this->getRules($on)) {
            return true;
        }
        $isValid = true;
        foreach ($this->rules[$on] as $validate) {
            $validate = array_pad($validate, 6, '');
            // formmat [field,input,detect,function,message,express]
            if (!$isField || in_array($validate[0], $this->columns)) {
                $value = false;
                $param = $this->_params($validate[1], $validate[0]);
                switch ($validate[2]) {
                    case self::FIELD_NOT_EMPTY:
                        if (!empty($param)) {
                            $value = $this->_validate($validate[3], $param, $validate[5]);
                        }
                        break;
                    case self::FIELD_ISSET:
                        if (isset($param)) {
                            $value = $this->_validate($validate[3], $param, $validate[5]);
                        }
                        break;
                    case self::FIELD_BOTH:
                        if (isset($param) && !empty($param)) {
                            $value = $this->_validate($validate[3], $param, $validate[5]);
                        }
                        break;
                }
                if ($value !== false) {
                    $this->_data[$validate[0]] = $value;
                } else {
                    $isValid = false;
                    $this->_error[] = $validate[4];
                }
            }
        }
        return $isValid ? $this->_data : false;
    }

    /**
     * Validate method
     * @param $function
     * @param $value
     * @param $expression
     * @return bool
     */
    public function _validate($function, $value, $expression)
    {
        if (method_exists($this, $function)) {
            return $this->$function($value, $expression) ? $value : false;
        } else if (function_exists($function)) {
            return $function($value, $expression) ? $value : false;
        } else if (method_exists($this->_validation, $function)) {
            return $this->_validation->$function($value, $expression) ? $value : false;
        } else {
            return $value;
        }
    }

    /**
     * Get error
     * @access public
     * @return mixed
     */
    public function getError()
    {
        return isset($this->_error[0]) ? $this->_error[0] : '';
    }

    /**
     * Get error list
     * @access public
     * @return array
     */
    public function getErrorList()
    {
        return $this->_error;
    }


    /**
     * Run validate
     * @param $input
     * @param $key
     * @return bool
     */
    public function _params($input, $key)
    {
        $params = array();
        if (strtolower($input) == 'put' || strtolower($input) == 'delete') {
            parse_str(file_get_contents('php://input'), $params);
            $_REQUEST = $params + $_REQUEST;
        } elseif (strtolower($input) == 'post') {
            $params =& $_POST;
        } elseif (strtolower($input) == 'get') {
            $params =& $_GET;
        } elseif (strtolower($input) == 'cookie') {
            $params =& $_COOKIE;
        } elseif (strtolower($input) == 'request') {
            $params =& $_REQUEST;
        }
        return isset($params[$key]) ? $params[$key] : '';

    }


    /**
     * Find a record by condition
     * @access public
     * @param array $condition
     * @return mixed
     */
    public function find($condition = array())
    {
        $row = $this->_criteria
            ->table($this->tableName())
            ->limit('1')
            ->select($condition);
        return isset($row[0]) ? $row[0] : array();
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
            ->table($this->tableName())
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
            ->table($this->tableName())
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
        if (method_exists($this, 'beforeAdd')) $this->beforeAdd();
        $result = $this->_criteria->table($this->tableName())->insert($data);
        if (method_exists($this, 'afterAdd')) $this->afterAdd();
        return $result;
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
        if (method_exists($this, 'beforeSave')) $this->beforeSave();
        $result = $this->_criteria->table($this->tableName())->update($data, $where);
        if (method_exists($this, 'afterSave')) $this->afterSave();
        return $result;
    }

    /**
     * Kill records with given where condition
     * @access public
     * @param null / string / array $where
     * @return mixed
     */
    public function remove($where = null)
    {
        if (method_exists($this, 'beforeRemove')) $this->beforeRemove();
        $result = $this->_criteria->table($this->tableName())->delete($where);
        if (method_exists($this, 'afterRemove')) $this->afterRemove();
        return $result;
    }

    /**
     * Get full table name
     * @access public
     * @param null / string $name
     * @return string
     */
    public function tableName($name = null)
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
     * Perform table optimize
     * @access public
     * @param string $tableName
     * @return mixed
     */
    public function optimizeTable($tableName)
    {
        return $this->_db->optimizeTable($tableName);
    }

    /**
     * Perform table repair
     * @access public
     * @param string $tableName
     * @return mixed
     */
    public function repairTable($tableName)
    {
        return $this->_db->repairTable($tableName);
    }

    /**
     * Get table engine
     * @access public
     * @param string $tableName
     * @return mixed
     */
    public function getTableEngine($tableName)
    {
        $this->_db->getTableEngine($tableName);
    }

    /**
     * Set table engine
     * @access public
     * @param string $tableName
     * @param string $engineName
     * @return void
     */
    public function setTableEngine($tableName, $engineName)
    {
        $this->_db->setTableEngine($tableName, $engineName);
    }

    /**
     * Get database version
     * @return mixed
     */
    public function version()
    {
        return $this->_db->version();
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
