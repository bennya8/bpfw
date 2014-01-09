<?php

class ModelHelper
{
	protected final $select = 'SELECT @COLUMN FROM @TABLE @JOIN @WHERE @GROUP @ORDER @LIMIT';
	protected final $insert = 'INSERT INTO @TABLE @DATA';
	protected final $update = 'UPDATE @TABLE SET @DATA @WHERE';
	protected final $delete = 'DELETE FROM @TABLE @WHERE';
	protected $safemode = true;
	protected $condition = array();
	protected $data = array();

	public function __construct()
	{
		
		
		// $config = Config::Get('Database');
// 		$this->safemode = isset($config['DB_SAFEMODE']) ? (boolean) $config['DB_SAFEMODE'] : true;
	}

	public function insert($condition,$data){
		$this->condition = $condition;
		$this->data = $data;
		$this->parseInsert();
		exit;
		$sql = str_replace(array(
			'@TABLE',
			'@COLUMN',
			'@DATA'
		), array(
			$this->parseTable(),
			$this->parseColumn(),
		), $this->insert);
		
	}
	
	protected function parseInsert(){
		$sql = '';
		$data = $this->data;
		if(!empty($data) && is_array($data)){
			list($column,$value) = $data;
			array_keys($data[0]);
			
		}
	}
	
	
	public function select($condition)
	{
		$this->condition = $condition;
		$sql = str_replace(array(
			'@COLUMN',
			'@TABLE',
			'@JOIN',
			'@WHERE',
			'@GROUP',
			'@ORDER',
			'@LIMIT'
		), array(
			$this->parseColumn(),
			$this->parseTable(),
			$this->parseWhere(),
			$this->parseJoin(),
			$this->parseGroup(),
			$this->parseOrder(),
			$this->parseLimit()
		), $this->select);
		return $sql;
	}

	public function update($conditon, $data)
	{}

	protected function parseColumn()
	{
		$sql = 'SELECT *';
		if (isset($this->condition['select']) && !empty($this->condition['select'])) {
			if (is_string($this->condition['select'])) {
				$sql = 'SELECT ' . $this->condition['select'];
			} else if (is_array($this->condition['select'])) {
				$sql = 'SELECT ' . implode(',', $this->condition['select']);
			}
		}
		return $sql;
	}

	protected function parseTable()
	{
		$sql = '';
		if (isset($this->condition['table']) && !empty($this->condition['table'])) {
			if (is_string($this->condition['table'])) {
				$sql = 'FROM ' . $this->condition['table'];
			} else if (is_array($this->condition['table'])) {
				$sql = 'FROM ' . implode(',', $this->condition['table']);
			}
		}
		return $sql;
	}

	protected function parseWhere()
	{
		$sql = '';
		if (isset($this->condition['where']) && !empty($this->condition['where'])) {
			if (is_string($this->condition['where'])) {
				$sql = 'WHERE ' . $this->condition['where'];
			} else if (is_array($this->condition['where'])) {
				$sql = 'WHERE ' . implode(',', $this->condition['where']);
			}
		}
		$this->select = str_replace('@WHERE', $sql, $this->select);
	}

	protected function parseJoin()
	{
		$sql = '';
		$condition = $this->condition['join'];
		if (isset($condition) && !empty($condition)) {
			if (is_array($condition)) {
				foreach ($condition as $join) {
					switch (strtolower($join[0])) {
						case 'right':
							$join[0] = 'RIGHT JOIN';
							break;
						case 'inner':
							$join[0] = 'INNER JOIN';
							break;
						case 'cross':
							$join[0] = 'CROSS JOIN';
							break;
						default:
							$join[0] = 'LEFT JOIN';
							break;
					}
					$sql .= $join[0] . ' ' . $join[1] . ' ON ' . $join[2] . ' ';
				}
			}
		}
		$this->select = str_replace('@JOIN', $sql, $this->select);
	}

	protected function parseGroup()
	{
		$sql = '';
		if (isset($this->condition['group']) && !empty($this->condition['group'])) {}
		$this->select = str_replace('@GROUP', $sql, $this->select);
	}

	protected function parseOrder()
	{
		$sql = '';
		if (isset($this->condition['order']) && !empty($this->condition['order'])) {}
		$this->select = str_replace('@ORDER', $sql, $this->select);
	}

	protected function parseLimit()
	{
		$sql = '';
		if (isset($this->condition['limit']) && !empty($this->condition['limit'])) {
			if (is_string($this->condition['limit'])) {
				$sql = 'LIMIT ' . $this->condition['limit'];
			} else if (is_array($this->condition['limit'])) {
				$sql = 'LIMIT ' . implode(',', $this->condition['limit']);
			}
		}
		$this->select = str_replace('@LIMIT', $sql, $this->select);
	}
}

$c1 = array(
	'select' => '*'
);

$c2 = array(
	'select' => array(
		'aaa as a',
		'bbb as b',
		'ccc as c'
	),
	'from' => 'aa',
	'join' => array(
		array(
			'right',
			'aaa',
			'a.a = b.a'
		),
		array(
			'left',
			'bbb',
			'a.a = b.a'
		)
	),
	'limit' => array(
		10,
		2000
	)
);

array(
	'aa' => 'aa',
	'bb' => 'cc',
	'dd' => 'ee'
)


$helper = new ModelHelper();
echo $helper->select($c2);