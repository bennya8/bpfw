<?php

class ModelHelper
{
	public $select = '@SELECT @FROM @JOIN @WHERE @GROUP @ORDER @LIMIT';
	protected $condition = array();

	public function select($condition)
	{
		$this->condition = $condition;
		$this->parseSelect();
		return $this->select;
	}

	public function update($conditon, $data)
	{}

	public function parseSelect()
	{
		if (isset($this->condition['select']) && !empty($this->condition['select'])) {
			if (is_string($this->condition['select'])) {
				$sql = 'SELECT ' . $this->condition['select'];
// 			}else if(){
				
			}
		} else {
			$sql = 'SELECT *';
		}
		$this->select = str_replace('@SELECT', $sql, $this->sql);
	}

	public function parseWhere()
	{}

	public function parseJoin()
	{}

	public function parseGroup()
	{}

	public function parseOrder()
	{}

	public function parseLimit()
	{}
}

$c1 = array(
	'select' => '*'
);

$helper = new ModelHelper();
echo $helper->getSQL($c1);