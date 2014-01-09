<?php

/**
 * PDO数据库实现类
 * @package Root.Framework.Core.DB
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Database_PDO extends Database implements IDatabase
{
	
	/**
	 * 数据库资源实例
	 * @access private
	 * @var resource
	 */
	private $_resource = null;
	
	/**
	 * 执行查询次数
	 * @access private
	 * @var int
	 */
	private $_lastQueryTimes = 0;
	
	/**
	 * 受影响的行数
	 * @access private
	 * @var int
	 */
	private $_lastAffectedRows = 0;
	
	/**
	 * SQL错误信息集
	 * @access public
	 * @var array
	 */
	private $_lastError = array();
	
	/**
	 * 数据库配置
	 * @access public
	 * @var array
	 */
	private $_config = array();

	/**
	 * 构造方法
	 * @access public
	 * @return void
	 */
	public function __construct($config)
	{
		$this->_config = $config;
		$this->getConnect($this->_config);
	}

	/**
	 * 获取数据库可用驱动
	 * @access public
	 * @return array 可用驱动列表
	 */
	public function getAvailableDrivers()
	{
		return PDO::getAvailableDrivers();
	}

	/**
	 * 获取数据库连接
	 * @param string $host IP地址
	 * @param string $port 端口号
	 * @param string $user 用户名
	 * @param string $password 密码
	 * @return boolean
	 */
	public function getConnect($c)
	{
		if (!class_exists('PDO')) {
			throw new BException(Config::Lang('_PDO_MODULE_MISSING_'));
		}
		$dsnName = str_replace('pdo:', '', strtolower($c['DB_ENGINE']));
		$dsnDrivers = $this->getAvailableDrivers();
		if (!array_search($dsnName, $dsnDrivers)) {
			throw new BException(Config::Lang('_PDO_MODULE_MISSING_') . ' => Extension: ' . $dsnName);
		}
		$dsn = $dsnName . ':host=' . $c['DB_HOST'] . ';dbname=' . $c['DB_NAME'] . ';port=' . $c['DB_PORT'];
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $c['DB_CHARSET']
		);
		try {
			$this->_resource = new PDO($dsn, $c['DB_USER'], $c['DB_PWD'], $options);
		} catch (PDOException $e) {
			throw new BException(Config::Lang('_DB_CONNECT_FAIL_') . ' => ' . $e->getMessage());
		}
	}

	/**
	 * 获取数据库属性值
	 * @access public
	 * @param string $optKey 数据库属性名
	 * @return string
	 */
	public function getAttribute($optKey)
	{
		return $this->_resource->getAttribute($optKey);
	}

	/**
	 * 设定数据库属性
	 * @access public
	 * @param string $optKey 数据库属性名
	 * @return void
	 */
	public function setAttribute($optKey, $optValue)
	{
		return $this->_resource->setAttribute($optKey, $optValue);
	}

	/**
	 * 设定数据库名称
	 * @access public
	 * @param string $name 数据库名称
	 * @throws BException 设定错误
	 * @return void
	 */
	public function setDbName($name)
	{
		if (false === $this->_resource->exec('USE  ' . $name)) {
			throw new BException(Config::Lang('_SELECT_DB_FAIL_') . ' => DB Name: ' . $name);
		}
	}

	/**
	 * 设定数据库字符集
	 * @access public
	 * @param string $name 字符集名称
	 * @throws BException 设定错误
	 * @return void
	 */
	public function setCharset($name)
	{
		if (false === $this->_resource->exec('SET NAMES ' . $name)) {
			throw new BException(Config::Lang('_SET_CHARSET_FAIL_') . ' => Charset: ' . $name);
		}
	}

	/**
	 * 获取数据库字符集
	 * @access public
	 * @return string 字符集
	 */
	public function getCharset()
	{
		// @todo
	}

	/**
	 * 获取服务端版本
	 * @access public
	 * @return string 服务端版本
	 */
	public function getServerVersion()
	{
		return $this->getAttribute(PDO::ATTR_SERVER_VERSION);
	}

	/**
	 * 获取客户端版本
	 * @access public
	 * @return string 客户端版本
	 */
	public function getClientVersion()
	{
		return $this->getAttribute(PDO::ATTR_CLIENT_VERSION);
	}

	/**
	 * 执行SQL DML语句，返回受影响行数
	 * @param string $sql DML语句
	 * @throws BException DML语句出错
	 * @return int 受影响行数 / false 失败
	 */
	public function execute($sql)
	{
		return $this->_lastAffectedRows = $this->_resource->exec($sql);
	}

	/**
	 * 执行SQL DQL语句，返回结果集
	 * @param string $sql DQL语句
	 * @throws BException DQL语句出错
	 * @return array 结果集 / false 失败
	 */
	public function query($sql)
	{
		return $this->_resource->query($sql);
	}

	/**
	 * 执行SQL DQL语句进行转义，返回结果集
	 * @param string $sql DQL语句
	 * @throws BException DQL语句出错
	 * @return array 结果集 / false 失败
	 */
	public function quoteQuery($sql)
	{
		return $this->_resource->quote($sql);
	}

	/**
	 * 开始一个事务
	 * @access public
	 * @return boolean true 开启成功 / false 开启失败
	 */
	public function transactionBegin()
	{
		return $this->_resource->beginTransaction();
	}

	/**
	 * 提交一个事务
	 * @access public
	 * @return boolean true 提交成功 / false 提交失败
	 */
	public function transactionCommit()
	{
		return $this->_resource->commit();
	}

	/**
	 * 回滚一个事务
	 * @access public
	 * @return boolean true 回滚成功 / false 回滚失败
	 */
	public function transactionRollback()
	{
		return $this->_resource->rollBack();
	}

	/**
	 * 获取最新一次查询次数
	 * @access public
	 * @return int 查询次数
	 */
	public function lastQueryTimes()
	{
		// @todo
	}

	/**
	 * 获取最新一次受影响行数
	 * @access public
	 * @return int 受影响行数
	 */
	public function lastAffectedRows()
	{
		return $this->_lastAffectedRows;
	}

	/**
	 * 获取最新一次插入行ID
	 * @access public
	 * @return int 插入行ID
	 */
	public function lastInsertId()
	{
		$this->_resource->lastInsertId();
	}

	/**
	 * 获取最新一次SQL错误信息
	 * @access public
	 * @return array SQL错误信息
	 */
	public function lastError()
	{
		// @todo
	}
	/* (non-PHPdoc)
	 * @see DB_Dao::getError()
	 */
	public function getError()
	{
		// TODO Auto-generated method stub
	}
	
	/* (non-PHPdoc)
	 * @see DB_Dao::getErrorList()
	 */
	public function getErrorList()
	{
		// TODO Auto-generated method stub
	}
}
?>