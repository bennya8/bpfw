<?php 

class IndexAction extends Action{
	
	
	public function index(){
		$this->assign('version', Application::$version);
		$this->display();
	}
}

?>