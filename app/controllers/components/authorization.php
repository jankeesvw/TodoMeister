<?php

class AuthorizationComponent extends Object {
	var $components = array('Session');
	
	/**
	* returns -1 if you don't have access
	* returns 1 if you have read acces
	* returns 2 if you have read and write access
	*/
	
    function checkAuthorization($project_id) {
		
		$Password = ClassRegistry::init('Password');
		$currentPassword = $Password->find('first', array('conditions' => array('project_id' => $project_id)));
		
		if(!$currentPassword){
			return 2;
		}else{
			
			$read = $this->Session->read('read');
			$write = $this->Session->read('write');
			
			if(!isset($read)) $read = array();
			if(!isset($write)) $write = array();
			
			if(in_array($project_id,$write) === TRUE) return 2;
			if(in_array($project_id,$read) === TRUE) return 1;
			
			return -1;
		}
        
    }
	function clear(){
		$this->Session->write('read',array());
		$this->Session->write('write',array());
	}
	function doLogin($project_id,$entered_password){
		$Password = ClassRegistry::init('Password');
		$currentPassword = $Password->find('first', array('conditions' => array('project_id' => $project_id)));
		
		$read_permission_projects = $this->Session->read('read');
		$write_permission_projects = $this->Session->read('write');
		
		if(!isset($write_permission_projects)){
			$write_permission_projects = array();
		}
		if(!isset($read_permission_projects)){
			$read_permission_projects = array();
		}
	
		if($entered_password === $currentPassword['Password']['read-write']){
			//read & write
			$write_permission_projects = array_merge($write_permission_projects,array($project_id));
			$write_permission_projects = array_unique($write_permission_projects);
			$this->Session->write('write',$write_permission_projects);
			return 2;
		}else if($entered_password === $currentPassword['Password']['read']){
			// read
			$read_permission_projects = array_merge($read_permission_projects,array($project_id));
			$read_permission_projects = array_unique($read_permission_projects);
			$this->Session->write('read',$read_permission_projects);
			return 1;
		}
		return -1;
	}
}

?>
