<?php 

namespace Wiicode\Core;

abstract class Component{
	private $_config = [];
	
	public function __construct(){
		
	
	}
	
	public function __call($class, $args) {
		//echo $class;
		//var_dump($args);
	}
	
	public static function __callstatic($class, $args) {
		//echo $class;
		//var_dump($args);
	}
}







?>