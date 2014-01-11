<?php

/**
 * 系统模型类
 * @package Root.Framework.Core.Model
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Model
{
	protected $pk = 'id';
	protected $fields = array();
	protected $tablePrefix = '';
	protected $tableShufix = '';
	protected $tableName = '';
	protected $tableFullName = '';
	protected $helper = null;
	
	/**
	 * 数据库资源实例
	 * @access public
	 * @var resource
	 */
	protected $db = null;

	/**
	 * 构造方法
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$dbConfig = Config::Get('Database');
		$this->tablePrefix = $dbConfig['DB_PREFIX'];
		$this->tableShufix = $dbConfig['DB_SHUFIX'];
		$this->tableName = empty($this->tableName) ? $this->getTableName() : $this->tableName;
		$this->tableFullName = $this->getTableFullName($this->tableName);
		$this->db = Database::Factory($dbConfig['DB_ENGINE']);
		$this->helper = Application::Create('ModelHelper', $this->tableFullName);
	}

	/**
	 * 模型查询：获取单条数据
	 * @access public
	 * @param array $condition 筛选条件
	 * @return array 成功获取 / false 获取失败 / nulL 记录不存在
	 */
	public function find($condition = null)
	{
		$condition['limit'] = '1';
		$condition['table'] = isset($condition['table']) ? $condition['table'] : $this->getTableFullName($this->tableName);
		$result = $this->db->query($this->helper->select($condition));
		return count($result) ? $result[0] : false;
	}

	/**
	 * 获取数据
	 * @access public
	 * @param array $condition 筛选条件
	 * @return array 成功获取 / false 获取失败 / nulL 记录不存在
	 */
	public function findAll($condition = null)
	{
		$condition['table'] = isset($condition['table']) ? $condition['table'] : $this->getTableFullName($this->tableName);
		return $this->db->query($this->helper->select($condition));
	}

	/**
	 * 新增数据
	 * @access public
	 * @param array $condition SQL语句组合
	 * @param array $data 插入数据集
	 * @return array 新增行数 / false 新增失败
	 */
	public function insert($data, $condition = null)
	{
		$condition['table'] = isset($condition['table']) ? $condition['table'] : $this->getTableFullName($this->tableName);
		return $this->db->execute($this->helper->insert($data, $condition));
	}

	/**
	 * 更新数据
	 * @access public
	 * @param array $condition SQL语句组合
	 * @param array $data 更新数据集
	 * @return array 更新行数 / false 更新失败
	 */
	public function update($data, $condition)
	{
		$condition['table'] = isset($condition['table']) ? $condition['table'] : $this->getTableFullName($this->tableName);
		return $this->db->execute($this->helper->update($data, $condition));
	}

	/**
	 * 删除数据
	 * @access public
	 * @param array $condition SQL语句组合
	 * @return int 删除行数 / false 删除失败
	 */
	public function delete($condition)
	{
		$condition['table'] = isset($condition['table']) ? $condition['table'] : $this->getTableFullName($this->tableName);
		return $this->db->execute($this->helper->delete($condition));
	}

	/**
	 * 获取表简略名
	 * @access public
	 * @return string 表简略名
	 */
	public function getTableName()
	{
		if (empty($this->tableName)) {
			$name = preg_replace("/[A-Z]/", "_\\0", substr(get_class($this), 0, -5));
			$this->tableName = strtolower(trim($name, "_"));
		}
		return $this->tableName;
	}

	/**
	 * 获取表全名
	 * @access public
	 * @return string 表全名
	 */
	public function getTableFullName($name)
	{
		return $this->tablePrefix . $name . $this->tableShufix;
	}

	/**
	 * 设定数据库名称
	 * @access public
	 * @param string $string 数据库名称
	 * @throws BException 设定错误
	 * @return void
	 * @see DB_MySQL::setDbName();
	 */
	public function setDbName($name)
	{
		$this->db->setDbName($name);
	}

	/**
	 * 设定数据库字符集
	 * @access public
	 * @param string $name 字符集名称
	 * @throws BException 设定错误
	 * @return void
	 * @see DB_MySQL::setCharset();
	 */
	public function setCharset($name)
	{
		$this->db->setCharset($name);
	}

	/**
	 * 获取数据库字符集
	 * @access public
	 * @return string 字符集
	 * @see DB_MySQL::getCharset();
	 */
	public function getCharset()
	{
		return $this->db->getCharset();
	}

	/**
	 * 获取服务端版本
	 * @access public
	 * @return string 服务端版本
	 * @see DB_MySQL::getServerVersion();
	 */
	public function getServerVersion()
	{
		return $this->db->getServerVersion();
	}

	/**
	 * 获取客户端版本
	 * @access public
	 * @return string 客户端版本
	 * @see DB_MySQL::getClientVersion();
	 */
	public function getClientVersion()
	{
		return $this->db->getClientVersion();
	}

	/**
	 * 执行SQL DQL语句，返回结果集
	 * @param string $sql DQL语句
	 * @throws BException DQL语句出错
	 * @return array 结果集 / false 失败
	 * @see DB_MySQL::query();
	 */
	public function query($sql)
	{
		return $this->db->query($sql);
	}

	/**
	 * 执行SQL DQL语句进行转义，返回结果集
	 * @param string $sql DQL语句
	 * @throws BException DQL语句出错
	 * @return array 结果集 / false 失败
	 * @see DB_MySQL::query();
	 */
	public function quoteQuery($sql)
	{
		return $this->db->quoteQuery($sql);
	}

	/**
	 * 执行SQL DML语句，返回受影响行数
	 * @param string $sql DML语句
	 * @throws BException DML语句出错
	 * @return int 受影响行数 / false 失败
	 * @see DB_MySQL::execute();
	 */
	public function execute($sql)
	{
		return $this->db->execute($sql);
	}

	/**
	 * 开始一个事务
	 * @access public
	 * @return boolean true 开启成功 / false 开启失败
	 * @see DB_MySQL::transactionBegin();
	 */
	public function transactionBegin()
	{
		return $this->db->transactionBegin();
	}

	/**
	 * 提交一个事务
	 * @access public
	 * @return boolean true 提交成功 / false 提交失败
	 * @see DB_MySQL::transactionCommit();
	 */
	public function transactionCommit()
	{
		return $this->db->transactionCommit();
	}

	/**
	 * 回滚一个事务
	 * @access public
	 * @return boolean true 回滚成功 / false 回滚失败
	 * @see DB_MySQL::transactionRollback();
	 */
	public function transactionRollback()
	{
		return $this->db->transactionRollback();
	}

	/**
	 * 获取最新一次查询次数
	 * @access public
	 * @return int 查询次数
	 * @see DB_MySQL::lastQueryTimes();
	 */
	public function lastQueryTimes()
	{
		return $this->db->lastQueryTimes();
	}

	/**
	 * 获取最新一次受影响行数
	 * @access public
	 * @return int 受影响行数
	 * @see DB_MySQL::lastAffectedRows();
	 */
	public function lastAffectedRows()
	{
		return $this->db->lastAffectedRows();
	}

	/**
	 * 获取最新一次插入行ID
	 * @access public
	 * @return int 插入行ID
	 * @see DB_MySQL::lastInsertId();
	 */
	public function lastInsertId()
	{
		return $this->db->lastInsertId();
	}

	/**
	 * 获取最新一次SQL错误信息
	 * @access public
	 * @return string SQL错误信息
	 */
	public function getError()
	{
		return $this->db->getError();
	}

	/**
	 * 获取SQL错误信息列表
	 * @access public
	 * @return array SQL错误信息列表
	 */
	public function getErrorList()
	{
		return $this->db->getErrorList();
	}

	/**
	 * 添加字符转义
	 * @access public
	 * @param mixed $value 要添加字符转义的字符串或数组
	 * @return mixed $value
	 */
	public function escape($value)
	{
		if (is_string($value)) {
			return addslashes($value);
		}
		if (is_array($value)) {
			foreach ($value as $k => $v) {
				if (is_string($v)) {
					$value[$k] = addslashes($v);
				}
				if (is_array($v)) {
					$value[$k] = array_merge($v, $this->escape($v));
				}
			}
			return $value;
		}
	}

	/**
	 * 去除字符转义
	 * @access public
	 * @param mixed $value 要去除字符转义的字符串或数组
	 * @return mixed $value
	 */
	public function unescape($value)
	{
		if (is_string($value)) {
			return stripslashes($value);
		}
		if (is_array($value)) {
			foreach ($value as $k => $v) {
				if (is_string($v)) {
					$value[$k] = stripslashes($v);
				}
				if (is_array($v)) {
					$value[$k] = array_merge($v, $this->unescape($v));
				}
			}
			return $value;
		}
	}

	/**
	 * 获取当前数据库引擎名称
	 * @access public
	 * @return object 实例
	 */
	public function getEngineName()
	{
		return get_class($this->db);
	}

	/**
	 * 获取当前数据库引擎
	 * @access public
	 * @return object 实例
	 */
	public function getEngine()
	{
		return $this->db;
	}

	/**
	 * 切换当前数据库引擎
	 * @access public
	 * @return object 实例
	 */
	public function setEngine($name)
	{
		$this->db = self::Factory($name);
	}

	/**
	 * 魔术方法，当调用Model内的方法不存在时
	 * 自动映射调用数据库引擎类里面方法
	 * @access public
	 * @param string $name 调用方法名 (自动传入)
	 * @param array $args 调用参数 (自动传入)
	 * @return mixed 调用方法的返回值
	 */
	public function __call($name, $args)
	{
		if (method_exists($this->db, $name)) {
			$method = Application::Create('ReflectionMethod', $this->db);
			if ($method->isPublic()) {
				$method->invokeArgs($this->db, $args);
			} else {
				throw new CustomException(Translate::Get('_CALL_METHOD_DENIED_') . ' => Class: ' . get_class($this->db) . ' Method: ' . $name . '()', 
						E_WARNING);
			}
		} else {
			throw new CustomException(Translate::Get('_CALL_NO_EXIST_METHOD_') . ' => Class: ' . get_class($this->db) . ' Method: ' . $name . '()', 
					E_WARNING);
		}
	}
}