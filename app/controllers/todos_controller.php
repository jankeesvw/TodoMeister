<?php
class TodosController extends AppController {

	var $name = 'Todos';
	var $helpers = array('Time','Javascript','Todo','RelativeTime');
	
	function todolist($project_id = "",$name = "") {
		
		if($project_id == "" || $name == ""){
			$this->redirect(array('action' => 'start',$project_id));
			exit;
		}
		
		$this->set('project_id',$project_id); 
		$this->set('name',$name);
		$this->set('statusOne', $this->Todo->find('all', array('conditions' => array('project_id' => $project_id,'status' => '1'),'order' => array('order','modified desc'))));
		$this->set('statusTwo', $this->Todo->find('all', array('conditions' => array('project_id' => $project_id,'status' => '2'),'order' => array('order','modified desc'))));
		$this->set('statusThree', $this->Todo->find('all', array('conditions' => array('project_id' => $project_id,'status' => '3'),'order' => array('order','modified desc'))));
	
		$this->set('title_for_layout', 'todomeister list'); 
		
		App::import('Helper', 'Html');
		$html = new HtmlHelper();
		$this->set('custom_title', $project_id.'<p> <a href="'.$html->url(array('action' => 'project_log',$project_id,$name)).'">show log</a></p>');
	}
	
	function start($project_id = ""){
		if(isset($_POST['projectname']) && isset($_POST['username'])){
			$this->redirect(array('action' => 'todolist',$_POST['projectname'],$_POST['username']));
			exit;
		}
		$this->set('title_for_layout', 'Welcome to todomeister'); 
	}
	
	function project_log($project_id = "",$name = "") {
		
		App::import('Helper', 'Html');
		$html = new HtmlHelper();
		
		$this->set('project_id',$project_id); 
		$this->set('name',$name);
		
		$this->set('revs',$this->Todo->ShadowModel->find('all',array('conditions' => array('project_id' => $project_id),'order' => array('id desc, modified desc'))));
		$this->set('custom_title', 'Project log for: <a href="'.$html->url(array("action" => "todolist",$project_id,$name)).'">'.$project_id.'</a>');
		$this->set('title_for_layout', 'Project log for: '.$project_id); 
	}

	function less() {
		$this->Session->write('more',false);
		$this->redirect($this->referer());
		exit;
	}

	
	function more() {
		$this->Session->write('more',true);
		$this->redirect($this->referer());
		exit;
	}
	
	function add($project_id,$name){
		if($this->Todo->save($this->data)){
			// valid save
		}else{
			$this->Session->setFlash('Error saving todo');
		}
		$this->redirect(array('action' => 'todolist',$project_id,$name,'#'.$this->data['Todo']['status']));
		exit;
	}

	function version($project_id){
		$item = $this->Todo->find('first', array('conditions' => array('project_id' => $project_id),'order' => array('modified DESC')));
		echo $item['Todo']['modified'];
		exit;
	}
	
	function log_item($id,$project_id,$name){
		$this->Todo->id = $id;
		$this->set('current', $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order'))));
		$this->set('history', $this->Todo->revisions());
		
		App::import('Helper', 'Html');
		$html = new HtmlHelper();
		$this->set('custom_title', '<a href="'.$html->url(array("action" => "todolist",$project_id,$name)).'">Item log</a>');
	}
	
	function color($id){
		$color = $_POST['color'];
		$item = $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order')));
		$item['Todo']['color'] = $color;
		unset($item['Todo']['modified']);
		$this->Todo->save($item);
		exit;
	}
	function order(){
		$ids = split(',',$_POST['order']);
		$dragged_item_id = $_POST['item'];
		$i = 0;
		foreach ($ids as $id) {
			$item = $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order')));
			$item['Todo']['order'] = $i;
			if($item['Todo']['id'] === $dragged_item_id){
				unset($item['Todo']['modified']);
			}
			$this->Todo->save($item);
			$i++;
		}
		exit;
	}
		
	function remove($id,$project_id,$name){
		$this->Todo->delete($id);
		$this->redirect(array('action' => 'todolist',$project_id,$name));
		exit;
	}
	
	function update($project_id,$name){
		$id = $_POST['id'];
		$todotext = $_POST['todo'];
		$item = $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order')));
		$item['Todo']['text'] = $todotext;
		$item['Todo']['who'] = $name;
		unset($item['Todo']['modified']);
		$this->Todo->save($item);
		$this->redirect($this->referer());
		exit;
	}
	
	function updateStatus($id,$new_status,$project_id,$name){
		$item = $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order')));
		$item['Todo']['status'] = $new_status;
		$item['Todo']['who'] = $name;
		$item['Todo']['order'] = "0";
		unset($item['Todo']['modified']);
		if($this->Todo->save($item)) {
			$this->redirect(array('action' => 'todolist',$project_id,$name));
		}
		echo "error!";
		exit;
	}
	
}
?>
