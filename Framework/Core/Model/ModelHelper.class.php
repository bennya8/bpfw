<?php

/**
 * 系统模型帮助类
 * @package Root.Framework.Core.Model
 * @author Benny <benny_a8@live.com>
 * @copyright ©2013 www.i3code.org
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class ModelHelper
{
	/**
	 * SELECT语句模板
	 * @var string
	 */
	protected $select = 'SELECT @DATA FROM @TABLE @JOIN @WHERE @GROUP @ORDER @LIMIT';
	/**
	 * INSERT语句模板
	 * @var string
	 */
	protected $insert = 'INSERT INTO @TABLE @DATA';
	/**
	 * UPDATE语句模板
	 * @var string
	 */
	protected $update = 'UPDATE @TABLE SET @DATA @WHERE';
	/**
	 * DELETE语句模板
	 * @var string
	 */
	protected $delete = 'DELETE FROM @TABLE @WHERE';
	/**
	 * SQL安全模式
	 * @var boolean
	 */
	protected $safemode = true;
	/**
	 * 语句组合
	 * @var array
	 */
	protected $condition = array();
	/**
	 * 语句数据
	 * @var array
	 */
	protected $data = array();
	
	/**
	 * 表名
	 * @var string
	 */
	protected $table = '';

	/**
	 * 生成select语句
	 * @access public
	 * @param string / array $condition 语句组合
	 * @return string SQL语句
	 */
	public function select($condition)
	{
		$this->condition = $condition;
		$search = array(
			'@DATA',
			'@TABLE',
			'@JOIN',
			'@WHERE',
			'@GROUP',
			'@ORDER',
			'@LIMIT'
		);
		$replace = array(
			$this->parseSelect(),
			$this->parseTable(),
			$this->parseJoin(),
			$this->parseWhere(),
			$this->parseGroup(),
			$this->parseOrder(),
			$this->parseLimit()
		);
		return str_replace($search, $replace, $this->select);
	}

	/**
	 * 生成insert语句
	 * @access public
	 * @param string / array $condition 语句组合
	 * @param array $data 插入数据 $k 对应列名，$v 对应值
	 * @return string SQL语句
	 */
	public function insert($data, $condition)
	{
		$this->condition = $condition;
		$this->data = $data;
		$search = array(
			'@TABLE',
			'@DATA'
		);
		$replace = array(
			$this->parseTable(),
			$this->parseInsert()
		);
		return str_replace($search, $replace, $this->insert);
	}

	/**
	 * 生成update语句
	 * @access public
	 * @param string / array $condition 语句组合
	 * @param array $data 更新数据 $k 对应列名，$v 对应值
	 * @return string SQL语句
	 */
	public function update($data, $condition)
	{
		$this->condition = $condition;
		$this->data = $data;
		$search = array(
			'@TABLE',
			'@DATA',
			'@WHERE'
		);
		$replace = array(
			$this->parseTable(),
			$this->parseUpdate(),
			$this->parseWhere()
		);
		return str_replace($search, $replace, $this->update);
	}

	/**
	 * 生成update语句
	 * @access public
	 * @param string / array $condition 语句组合
	 * @return string SQL语句
	 */
	public function delete($condition)
	{
		$this->condition = $condition;
		$search = array(
			'@TABLE',
			'@WHERE'
		);
		$replace = array(
			$this->parseTable(),
			$this->parseWhere()
		);
		return str_replace($search, $replace, $this->delete);
	}

	/**
	 * 分析insert
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseUpdate()
	{
		$sql = '';
		if (!empty($this->data) && is_array($this->data)) {
			foreach ($this->data as $k => $v) {
				$sql .= '`' . $k . '` = \'' . $v . '\',';
			}
			$sql = rtrim($sql, ',');
		}
		return $sql;
	}

	/**
	 * 分析insert
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseInsert()
	{
		$sql = '';
		if (!empty($this->data) && is_array($this->data)) {
			$k = array_keys($this->data);
			$v = array_values($this->data);
			$sql .= '(`' . implode('`,`', $k) . '`) VALUES ';
			$sql .= '(\'' . implode('\',\'', $v) . '\')';
		}
		return $sql;
	}

	/**
	 * 分析select
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseSelect()
	{
		$sql = '*';
		if ($this->checkAvaliable('select')) {
			if (is_string($this->condition['select'])) {
				$sql = $this->condition['select'];
			} else if (is_array($this->condition['select'])) {
				$sql = implode(',', $this->condition['select']);
			}
		}
		return $sql;
	}

	/**
	 * 分析table
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseTable()
	{
		$sql = '';
		if ($this->checkAvaliable('table')) {
			if (is_string($this->condition['table'])) {
				$sql = $this->condition['table'];
			} else if (is_array($this->condition['table'])) {
				$sql = implode(',', $this->condition['table']);
			}
		}
		return $sql;
	}

	/**
	 * 分析where
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseWhere()
	{
		$sql = '';
		if ($this->checkAvaliable('where')) {
			if (is_string($this->condition['where'])) {
				$sql = 'WHERE ' . $this->condition['where'];
			} else if (is_array($this->condition['where'])) {
				$sql = 'WHERE ';
				foreach ($this->condition['where'] as $k => $v) {
					if (isset($v[0]) && isset($v[1])) {
						switch (strtolower($v[0])) {
							case 'in':
								$where = ' IN ';
								if (is_array($v[1])) {
									$v[1] .= '(\'' . implode('\',\'', $v[1]) . '\')';
								} else if (is_string($v[1])) {
									$v[1] .= '(' . $v[1] . ')';
								}
								break;
							case 'notin':
								$where = ' NOT IN ';
								if (is_array($v[1])) {
									$v[1] .= '(\'' . implode('\',\'', $v[1]) . '\')';
								} else if (is_string($v[1])) {
									$v[1] .= '(' . $v[1] . ')';
								}
								break;
							case 'neq':
								$where = ' != ';
								break;
							case 'lteq':
								$where = ' <= ';
								break;
							case 'gteq':
								$where = ' >= ';
								break;
							case 'lt':
								$where = ' < ';
								break;
							case 'gt':
								$where = ' > ';
								break;
							case 'like':
								$where = ' LIKE ';
								break;
							default:
								$where = ' = ';
						}
						$logic = isset($v[2]) ? ' ' . $v[2] : '';
						$sql .= $k . $where . '\'' . $v[1] . '\'' . $logic . ' ';
					}
				}
			}
		}
		return $sql;
	}

	/**
	 * 分析select
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseJoin()
	{
		$sql = '';
		if ($this->checkAvaliable('join')) {
			if (is_array($this->condition['join'])) {
				foreach ($this->condition['join'] as $k => $v) {
					if (isset($v[0]) && isset($v[1])) {
						switch (strtolower($k)) {
							case 'right':
								$sql = 'RIGHT JOIN ';
								break;
							case 'inner':
								$sql = 'INNER JOIN ';
								break;
							case 'union':
								$sql = 'UNION JOIN ';
								break;
							default:
								$sql = 'LEFT JOIN ';
								break;
						}
						$sql .= $v[0] . ' ON ' . $v[1] . ' ';
					}
				}
			}
		}
		return $sql;
	}

	/**
	 * 分析group
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseGroup()
	{
		$sql = '';
		if ($this->checkAvaliable('group')) {
			if (is_string($this->condition['group'])) {
				$sql = 'GROUP BY ' . $this->condition['group'];
			} else if (is_array($this->condition['group'])) {
				$sql = 'GROUP BY ' . implode(',', $this->condition['group']);
			}
		}
		return $sql;
	}

	/**
	 * 分析order
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseOrder()
	{
		$sql = '';
		if ($this->checkAvaliable('order')) {
			if (is_string($this->condition['order'])) {
				$sql = 'ORDER BY ' . $this->condition['order'];
			} else if (is_array($this->condition['order'])) {
				$sql = 'ORDER BY ' . implode(',', $this->condition['order']);
			}
		}
		return $sql;
	}

	/**
	 * 分析limit
	 * @access protected
	 * @return string SQL片段
	 */
	protected function parseLimit()
	{
		$sql = '';
		if ($this->checkAvaliable('limit')) {
			if (is_string($this->condition['limit'])) {
				$sql = 'LIMIT ' . $this->condition['limit'];
			} else if (is_array($this->condition['limit'])) {
				$sql = 'LIMIT ' . implode(',', $this->condition['limit']);
			}
		}
		return $sql;
	}

	/**
	 * 检查语句组合是否合法
	 * @param string $key 语句组合键
	 * @return boolean
	 */
	protected function checkAvaliable($key)
	{
		return isset($this->condition[$key]) && !empty($this->condition[$key]) ? true : false;
	}
}