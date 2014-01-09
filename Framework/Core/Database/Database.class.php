<?php

/**
 * 数据库中间类
 * @package Root.Framework.Core.DB
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
abstract class Database extends Component
{
	/**
	 * 数据库资源实例
	 * @access protected
	 * @var resource
	 */
	protected $resource = null;
	
	/**
	 * 执行查询次数
	 * @access protected
	 * @var int
	 */
	protected $lastQueryTimes = 0;
	
	/**
	 * SQL语句错误列表
	 * @access protected
	 * @var array
	 */
	protected $errorList = array();

	/**
	 * 初始化数据库配置
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->config = Config::Get('Database');
	}

	/**
	 * 获取一条SQL错误信息
	 * @access public
	 * @return string SQL错误信息
	 */
	public function getError()
	{
		return array_pop($this->errorList);
	}

	/**
	 * 记录一条SQL错误信息
	 */
	public function setError($message)
	{
		array_push($this->errorList, $message);
	}

	/**
	 * 获取SQL错误信息列表
	 * @access public
	 * @return array SQL错误信息列表
	 */
	public function getErrorList()
	{
		return $this->errorList;
	}

	/**
	 * 数据库工厂，(单例模式)
	 * @access public
	 * @param string $name 类名
	 * @return object 数据库实例
	 */
	public static function Factory($name)
	{
		switch ($name) {
			case 'MySQLi':
				return Application::Create('Database_MySQLi');
				break;
			case 'MySQL':
				return Application::Create('Database_MySQL');
				break;
			default:
				return Application::Create('Database_PDO');
		}
	}
}