<?php

/**
 * 数据库接口
 * @package Root.Framework.Core.DB
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
interface DB_Dao
{

	/**
	 * 设定数据库名称
	 * @param string $name 数据库名称
	 */
	public function setDbName($name);

	/**
	 * 设定数据库字符集
	 * @param string $name 字符集名称
	 */
	public function setCharset($name);

	/**
	 * 获取数据库字符集
	 */
	public function getCharset();

	/**
	 * 获取服务端版本
	 */
	public function getServerVersion();

	/**
	 * 获取客户端版本
	 */
	public function getClientVersion();

	/**
	 * 执行SQL DQL语句，返回结果集
	 * @param string $sql DML语句
	 */
	public function query($sql);

	/**
	 * 执行SQL DML语句，返回受影响行数
	 * @param string $sql DQL语句
	 */
	public function execute($sql);

	/**
	 * 开始一个事务
	 */
	public function transactionBegin();

	/**
	 * 提交一个事务
	 */
	public function transactionCommit();

	/**
	 * 回滚一个事务
	 */
	public function transactionRollback();

	/**
	 * 获取最新一次查询次数
	 */
	public function lastQueryTimes();

	/**
	 * 获取最新一次受影响行数
	 */
	public function lastAffectedRows();

	/**
	 * 获取最新一次插入行ID
	 */
	public function lastInsertId();

	/**
	 * 获取最新一条SQL错误信息
	 */
	public function getError();
	
	/**
	 * 获取SQL错误信息列表
	 */
	public function getErrorList();
}
?>