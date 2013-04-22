<?php 

class IndexAction extends Action{
	
	
	public function index(){
		$this->assign('version', App::$version);
		$this->display();
	}
}

?>