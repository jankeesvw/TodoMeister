<?php
	class StatisticsController extends AppController {
		
		var $uses = array("Todos","Passwords");
		var $helpers = array("Chart","Javascript");
		
		function index(){
			$this->set('numberOfTodos', $this->Todos->find('count'));
			$this->set('numberOfTodosCreatedToday', $this->Todos->find('count',array('conditions'=>array("created >" => date('Y-m-d', strtotime("today"))))));
			$this->set('numberOfTodosModifiedToday', $this->Todos->find('count',array('conditions'=>array("modified >" => date('Y-m-d', strtotime("today"))))));
			$this->set('numberOfLists', $this->Todos->find('count', array('fields' => 'DISTINCT project_id')));
			$this->set('numberOfPasswords', $this->Passwords->find('count'));
			$this->set('numberOfUsers', $this->Todos->find('count', array('fields' => 'DISTINCT who')));
			$this->set('createdItemsPerDay', $this->Todos->find('all',array('fields' => "count(id) as count, DATE_FORMAT(created, '%d') as 'created_day'",'group'=>'created_day','order' => 'created_day','conditions'=>array("created >" => date('Y-m-d', strtotime("-1 month"))))));
			
			$this->Todos->find('count');
			
			$this->set('custom_title', 'Statistics for todomeister');
			
			$this->layout = 'centered';
		}
		
	}
?>