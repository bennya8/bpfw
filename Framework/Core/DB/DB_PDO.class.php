<?php

/**
 * PDO数据库实现类
 * @package Root.Framework.Core.DB
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class DB_PDO extends DB implements DB_Dao
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
	public function __construct()
	{
		//@todo
	}

	/**
	 * 获取数据库连接
	 * @param string $host IP地址
	 * @param string $port 端口号
	 * @param string $user 用户名
	 * @param string $password 密码
	 * @return boolean
	 */
	private function getConnect($host, $port, $user, $password)
	{
		//@todo
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
		//@todo
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
		//@todo
	}

	/**
	 * 获取数据库字符集
	 * @access public
	 * @return string 字符集
	 */
	public function getCharset()
	{
		//@todo
	}

	/**
	 * 获取服务端版本
	 * @access public
	 * @return string 服务端版本
	 */
	public function getServerVersion()
	{
		//@todo
	}

	/**
	 * 获取客户端版本
	 * @access public
	 * @return string 客户端版本
	 */
	public function getClientVersion()
	{
		//@todo
	}

	/**
	 * 执行SQL DML语句，返回受影响行数
	 * @param string $sql DML语句
	 * @throws BException DML语句出错
	 * @return int 受影响行数 / false 失败
	 */
	public function execute($sql)
	{
		//@todo
	}

	/**
	 * 执行SQL DQL语句，返回结果集
	 * @param string $sql DQL语句
	 * @throws BException DQL语句出错
	 * @return array 结果集 / false 失败
	 */
	public function query($sql)
	{
		//@todo
	}

	/**
	 * 开始一个事务
	 * @access public
	 * @return boolean true 开启成功 / false 开启失败
	 */
	public function transactionBegin()
	{
		//@todo
	}

	/**
	 * 提交一个事务
	 * @access public
	 * @return boolean true 提交成功 / false 提交失败
	 */
	public function transactionCommit()
	{
		//@todo
	}

	/**
	 * 回滚一个事务
	 * @access public
	 * @return boolean true 回滚成功 / false 回滚失败
	 */
	public function transactionRollback()
	{
		//@todo
	}

	/**
	 * 获取最新一次查询次数
	 * @access public
	 * @return int 查询次数
	 */
	public function lastQueryTimes()
	{
		//@todo
	}

	/**
	 * 获取最新一次受影响行数
	 * @access public
	 * @return int 受影响行数
	 */
	public function lastAffectedRows()
	{
		//@todo
	}

	/**
	 * 获取最新一次插入行ID
	 * @access public
	 * @return int 插入行ID
	 */
	public function lastInsertId()
	{
		//@todo
	}

	/**
	 * 获取最新一次SQL错误信息
	 * @access public
	 * @return array SQL错误信息
	 */
	public function lastError()
	{
		//@todo
	}
}
?>