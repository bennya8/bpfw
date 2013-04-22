<?php

/**
 * MySQLi数据库实现类
 * @package Root.Framework.Core.DB
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class DB_MySQLi extends DB implements DB_Dao
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
	 * 数据库配置
	 * @access private
	 * @var array
	 */
	private $_config = array();

	/**
	 * 构造方法，初始化数据库资源
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->_config = Config::Conf('DB_CONFIG');
		$this->getConnect($this->_config['DB_HOST'], $this->_config['DB_USER'], 
				$this->_config['DB_PWD'], $this->_config['DB_NAME'], $this->_config['DB_PORT']);
		$this->setCharset($this->_config['DB_CHARSET']);
	}

	/**
	 * 构析方法，关闭数据库资源
	 * @access public
	 * @return void
	 */
	public function __destruct()
	{
		$this->_resource->close();
	}

	/**
	 * 获取数据库连接
	 * @access public
	 * @param string $host IP地址
	 * @param string $port 端口号
	 * @param string $user 用户名
	 * @param string $password 密码
	 * @return void
	 */
	public function getConnect($host, $user, $password, $dbname, $port)
	{
		if (!function_exists('mysqli_connect')) {
			throw new BException(Config::Lang('_MYSQLI_MODULE_NO_EXIST_'));
		}
		$this->_resource = new mysqli($host, $user, $password, $dbname, $port);
	}

	/**
	 * 设定数据库名称
	 * @access public
	 * @param string 数据库名称
	 * @throws BException 设定错误
	 * @return void
	 */
	public function setDbName($name)
	{
		if (!$this->_resource->select_db($name)) {
			throw new BException(
					Config::Lang('_MYSQL_SETCHARSET_FAIL_') . ' => ' . mysqli_error(
							$this->_resource));
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
		if (!$this->_resource->set_charset($name)) {
			throw new BException(
					Config::Lang('_MYSQL_SETCHARSET_FAIL_') . ' => ' . mysqli_error(
							$this->_resource));
		}
	}

	/**
	 * 获取数据库字符集
	 * @access public
	 * @return string 字符集
	 */
	public function getCharset()
	{
		return $this->_resource->character_set_name();
	}

	/**
	 * 获取服务端版本
	 * @access public
	 * @return string 服务端版本
	 */
	public function getServerVersion()
	{
		return $this->_resource->server_info;
	}

	/**
	 * 获取客户端版本
	 * @access public
	 * @return string 客户端版本
	 */
	public function getClientVersion()
	{
		return $this->_resource->client_info;
	}

	/**
	 * 执行SQL DML语句，返回受影响行数
	 * @param string $sql DML语句
	 * @throws BException DML语句出错
	 * @return int 受影响行数 / false 失败
	 */
	public function execute($sql)
	{
		if (!$statment = $this->_resource->prepare($sql)) {
			return false;
		}
		if ($statment->execute()) {
			return $statment->affected_rows;
		}
		$statment->free_result();
		$statment->close();
		return false;
	}

	/**
	 * 执行SQL DQL语句，返回结果集
	 * @param string $sql DQL语句
	 * @throws BException DQL语句出错
	 * @return array 结果集 / false 失败
	 */
	public function query($sql)
	{
		if (!$result = $this->_resource->query($sql)) {
			return false;
		}
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$list[] = $row;
			}
			return $list;
		}
		$result->free();
		$result->close();
		$this->_lastQueryTimes++;
		return false;
	}

	/**
	 * 开始一个事务
	 * @access public
	 * @return boolean true 开启成功 / false 开启失败
	 */
	public function transactionBegin()
	{
		return $this->_resource->autocommit(false);
	}

	/**
	 * 提交一个事务
	 * @access public
	 * @return boolean true 提交成功 / false 提交失败
	 */
	public function transactionCommit()
	{
		return $this->_resource->commit;
	}

	/**
	 * 回滚一个事务
	 * @access public
	 * @return boolean true 回滚成功 / false 回滚失败
	 */
	public function transactionRollback()
	{
		return $this->_resource->rollback;
	}

	/**
	 * 获取最新一次查询次数
	 * @access public
	 * @return int 查询次数
	 */
	public function lastQueryTimes()
	{
		return $this->_lastQueryTimes;
	}

	/**
	 * 获取最新一次受影响行数
	 * @access public
	 * @return int 受影响行数
	 */
	public function lastAffectedRows()
	{
		return $this->_resource->affected_rows;
	}

	/**
	 * 获取最新一次插入行ID
	 * @access public
	 * @return int 插入行ID
	 */
	public function lastInsertId()
	{
		return $this->_resource->insert_id;
	}

	/**
	 * 获取最新一次SQL错误信息
	 * @access public
	 * @return string SQL错误信息
	 */
	public function getError()
	{
		return $this->_resource->error;
	}

	/**
	 * 获取SQL错误信息列表
	 * @access public
	 * @return array SQL错误信息列表
	 */
	public function getErrorList()
	{
		return $this->_resource->error_list;
	}
}
?>