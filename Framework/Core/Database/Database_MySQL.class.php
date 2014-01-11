<?php

/**
 * MySQL数据库实现类
 * @package Root.Framework.Core.DB
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Database_MySQL extends Database implements IDatabase
{

	/**
	 * 初始化资源
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->getConnect();
		$this->setDbName($this->DB_NAME);
		$this->setCharset($this->DB_CHARSET);
	}

	/**
	 * 释放资源
	 * @access public
	 * @return void
	 */
	public function __destruct()
	{
		mysql_close($this->resource);
	}

	/**
	 * 获取数据库连接
	 * @access public
	 * @param string $host IP地址
	 * @param string $port 端口号
	 * @param string $user 用户名
	 * @param string $password 密码
	 * @return boolean
	 */
	public function getConnect()
	{
		if (!function_exists('mysql_connect')) {
			throw new CustomException(Translate::Get('_MYSQL_MODULE_NO_EXIST_'));
		}
		if (!$this->resource = mysql_connect($this->DB_HOST . ':' . $this->DB_PORT, $this->DB_USER, $this->DB_PWD)) {
			throw new CustomException(Translate::Get('_DB_CONNECT_FAIL_') . ' => ' . mysql_error());
		}
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
		if (!mysql_select_db($name, $this->resource)) {
			throw new CustomException(Translate::Get('_SELECT_DB_FAIL_') . ' => ' . mysql_error());
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
		if (!mysql_set_charset($name, $this->resource)) {
			throw new CustomException(Translate::Get('_SET_CHARSET_FAIL_') . ' => ' . mysql_error());
		}
	}

	/**
	 * 获取数据库字符集
	 * @access public
	 * @return string 字符集
	 */
	public function getCharset()
	{
		return mysql_client_encoding($this->resource);
	}

	/**
	 * 获取服务端版本
	 * @access public
	 * @return string 服务端版本
	 */
	public function getServerVersion()
	{
		return mysql_get_server_info();
	}

	/**
	 * 获取客户端版本
	 * @access public
	 * @return string 客户端版本
	 */
	public function getClientVersion()
	{
		return mysql_get_client_info();
	}

	/**
	 * 执行SQL DML语句，返回受影响行数
	 * @param string $sql DML语句
	 * @throws BException DML语句出错
	 * @return int 受影响行数 / false 失败
	 */
	public function execute($sql)
	{
		if (!mysql_query($sql, $this->resource)) {
			$this->setError(mysql_error());
			return false;
		}
		return $this->lastAffectedRows();
	}

	/**
	 * 执行SQL DQL语句，返回结果集
	 * @param string $sql DQL语句
	 * @throws BException DQL语句出错
	 * @return array 结果集 / false 失败
	 */
	public function query($sql)
	{
		$list = array();
		if (!$result = mysql_query($sql, $this->resource)) {
			$this->setError(mysql_error());
			return false;
		}
		while ($row = mysql_fetch_assoc($result)) {
			$list[] = $row;
		}
		mysql_freeresult($result);
		$this->lastQueryTimes++;
		return $list;
	}

	/**
	 * 执行SQL DQL语句进行转义，返回结果集
	 * @param string $sql DQL语句
	 * @throws BException DQL语句出错
	 * @return array 结果集 / false 失败
	 */
	public function quoteQuery($sql)
	{
		$sql = mysql_real_escape_string($sql);
		if (!$result = mysql_query($sql, $this->resource)) {
			$this->setError(mysql_error());
			return false;
		}
		while ($row = mysql_fetch_assoc($result)) {
			$list[] = $row;
		}
		mysql_freeresult($result);
		$this->lastQueryTimes++;
		return $list;
	}

	/**
	 * 开始一个事务
	 * @access public
	 * @return boolean true 开启成功 / false 开启失败
	 */
	public function transactionBegin()
	{
		return mysql_query('begin');
	}

	/**
	 * 提交一个事务
	 * @access public
	 * @return boolean true 提交成功 / false 提交失败
	 */
	public function transactionCommit()
	{
		return mysql_query('commit');
	}

	/**
	 * 回滚一个事务
	 * @access public
	 * @return boolean true 回滚成功 / false 回滚失败
	 */
	public function transactionRollback()
	{
		return mysql_query('rollback');
	}

	/**
	 * 获取最新一次查询次数
	 * @access public
	 * @return int 查询次数
	 */
	public function lastQueryTimes()
	{
		return $this->lastQueryTimes;
	}

	/**
	 * 获取最新一次受影响行数
	 * @access public
	 * @return int 受影响行数
	 */
	public function lastAffectedRows()
	{
		return mysql_affected_rows();
	}

	/**
	 * 获取最新一次插入行ID
	 * @access public
	 * @return int 插入行ID
	 */
	public function lastInsertId()
	{
		return mysql_insert_id();
	}
}
