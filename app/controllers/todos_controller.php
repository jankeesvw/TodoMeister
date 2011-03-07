<?php
class TodosController extends AppController {

	var $name = 'Todos';
	var $helpers = array('Time','Javascript','Todo','RelativeTime');
	var $uses = array('Todo','Password');
	var $components = array('Authorization');

	/**
	* Homepage
	*/
	function start($project_id = ""){
		// form is posted redirect to todolist
		
		if(isset($_POST['projectname']) && isset($_POST['username']) && $_POST['projectname'] ==! "" && $_POST['username']  ==! ""){
			$this->redirect(array('action' => 'todolist',$_POST['projectname'],$_POST['username']));
			exit;
		}
		
		if(isset($_POST['projectname']) && $_POST['projectname'] ==! ""){
			$project_id = $_POST['projectname'];
			$this->Session->setFlash('Please fill in your name.');
		}else if(isset($_POST['projectname']) && isset($_POST['username']) && $_POST['projectname'] === "" && $_POST['username']  === ""){
			$this->Session->setFlash('Please fill in your name and a project name.');
		}
		
		$this->set('project_id',$project_id);
		$this->set('title_for_layout', 'Welcome to todomeister'); 
		$this->layout = 'centered';
	}
	

	function list_index(){
		if(Configure::read('TodoMeister.build_index') !== true){
			$this->Session->setFlash('Sorry, that\'s not allowed');
			$this->redirect(array('action' => 'ahahah'));
			exit;
		}
		$lists = $this->Todo->find('all', array('fields' => 'count(id) as count, project_id','group'=>'project_id','order'=>'project_id'));
		$this->set('lists', $lists);
		
		$this->layout = 'centered';
	}
	
	function ahahah(){
		$this->layout = 'empty';	
	}
	
	
	/**
	* Main todo list page
	*/
	function todolist($project_id,$name = "") {
		
		$auth_level = $this->Authorization->checkAuthorization($project_id);
	
		if($auth_level < 0){
			// redirect back to the login page
			$this->Session->setFlash('This project requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
		
		if($name == ""){
			$this->redirect(array('action' => 'start',$project_id));
			exit;
		}

		$this->set('project_id',$project_id); 
		$this->set('name',$name);
		$this->set('statusOne', $this->Todo->find('all', array('conditions' => array('project_id' => $project_id,'status' => '1'),'order' => array('order','modified desc'))));
		$this->set('statusTwo', $this->Todo->find('all', array('conditions' => array('project_id' => $project_id,'status' => '2'),'order' => array('order','modified desc'))));
		$this->set('statusThree', $this->Todo->find('all', array('conditions' => array('project_id' => $project_id,'status' => '3'),'order' => array('order','modified desc'))));
		
		// create a custom title for the page
		App::import('Helper', 'Html');
		$html = new HtmlHelper();
		
		// Editing as Jankees. Not Jankees? Change name here...
		$sublink = "Editing as ". $name .". Not ". $name . "? " . $html->link("Change here...", array("action"=>"start",$project_id));
		
		if($auth_level > 1){
			
			$locklink = $html->link($html->image($html->url('/img/book_open.png'),array('title' => 'open project log')), array('action' => 'project_log',$project_id,$name),array('escape' => false));
			
			if($this->Password->find('first', array('conditions' => array('project_id' => $project_id)))){
				$locklink .= $html->link($html->image($html->url('/img/lock_edit.png'), array('title' => 'change password')), array('action' => 'password',$project_id,$name),array('escape' => false));	
			}else{
				$locklink .= $html->link($html->image($html->url('/img/lock_add.png'), array('title' => 'add password protection')), array('action' => 'password',$project_id,$name),array('escape' => false));	
			}
		}else{
			$locklink = $html->link($html->image($html->url('/img/pencil_delete.png'), array('title' => 'read only access')), array('action' => 'login',$project_id,$name),array('escape' => false));	
		}
		
		$this->set('title_for_layout', $project_id.' - '.$name. ' on Todomeister'); 		
		
		$this->set('custom_title', $project_id.$locklink);
		$this->set('custom_sub_title', $sublink);
		
		$this->set('auth_level', $auth_level);
	}
	
	function logout() {
		$this->Authorization->clear();
		// redirect back to the list with a #status to regain focus
		$this->redirect(array('action' => 'start'));
		exit;
	}
	function login($project_id,$name = "") {
		if($this->data){
			if($this->Authorization->doLogin($project_id,$this->data['Password']['password']) > 0){
				$this->redirect(array('action' => 'todolist',$project_id,$name));
				exit;
			}else{
				$this->Session->setFlash('Sorry, invalid password!');
				$this->data['Password']['password'] = "";
			}		
		}
		$this->set('project_id',$project_id); 
		$this->set('name',$name);
		$this->layout = 'centered';
	}
	
	function remove_password($project_id,$name){
		if($this->Authorization->checkAuthorization($project_id) < 2){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}		
		
		$current = $this->Password->find('first', array('conditions' => array('project_id' => $project_id)));
		if($current){
			$this->Password->delete($current['Password']['id']);
		}
		
		$this->redirect(array('action' => 'todolist',$project_id,$name));		
	}
	
	function password($project_id,$name){
		if($this->Authorization->checkAuthorization($project_id) < 2){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
		
		if($this->data){
			$current = $this->Password->find('first', array('conditions' => array('project_id' => $project_id)));
			if($current){
				if($this->data['Password']['read'] === "" && $this->data['Password']['read-write']===""){
					$this->Password->delete($this->data['Password']['id']);
					// redirect back to the list
					$this->redirect(array('action' => 'todolist',$project_id,$name));
					exit;
				}
				
				$this->data = $current;
			}
			
			$this->data['Password']['read'] = md5($this->data['Password']['read']);
			$this->data['Password']['read-write'] = md5($this->data['Password']['read-write']);
			
			$this->data['Password']['project_id'] = $project_id;
			$this->Password->save($this->data);
			
			// redirect back to the list
			$this->redirect(array('action' => 'todolist',$project_id,$name));
			exit;
		}else{
			$this->data = $this->Password->find('first', array('conditions' => array('project_id' => $project_id)));
			$this->set('name', $name);
			$this->set('project_id', $project_id);

		}
		$this->layout = 'centered';	
	}
	
	
	/**
	* Fetch the current version information for the todolist (used for AJAX updating)
	*/
	function version($project_id){
		
		$item = $this->Todo->find('first', array('conditions' => array('project_id' => $project_id),'order' => array('modified DESC')));
		echo $item['Todo']['modified'];
		exit;
	}
	
	/**
	* Project log
	*/
	function project_log($project_id,$name) {
		if($this->Authorization->checkAuthorization($project_id) < 0){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
	
		$this->set('project_id',$project_id); 
		$this->set('name',$name);

		// get all revisions based on one project
		$this->set('revs',$this->Todo->ShadowModel->find('all',array('conditions' => array('project_id' => $project_id),'order' => array('id desc, modified'))));
		
		// create a custom title for the page
		App::import('Helper', 'Html');
		$html = new HtmlHelper();		
		$this->set('custom_title', 'Project log for: <a href="'.$html->url(array("action" => "todolist",$project_id,$name)).'">'.$project_id.'</a>');
		$this->set('title_for_layout', 'Project log for: '.$project_id);
		
	}

	/**
	* Add a todo to the list
	*/
	function add($project_id,$name){
		if($this->Authorization->checkAuthorization($project_id) < 2){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
		
		if(!$this->Todo->save($this->data)){
			$this->Session->setFlash('Error saving todo, did you enter a text?');
			$this->redirect(array('action' => 'todolist',$project_id,$name,'#'.$this->data['Todo']['status']));
			exit;
		}
		
		$items = $this->Todo->find('all', array('conditions' => array('project_id' => $project_id,'status' => $this->data['Todo']['status']),'order' => array('order','modified desc')));
		$iterator = 0;
		foreach ($items as $item) {
			if($item['Todo']['order'] != $iterator){
				$item['Todo']['order'] = $iterator;
				$this->Todo->save($item);
			}				
			$iterator++;
		}

		// redirect back to the list with a #status to regain focus
		$this->redirect(array('action' => 'todolist',$project_id,$name,'#'.$this->data['Todo']['status']));
		exit;
	}
	
	/**
	* See the log of one item
	*/
	function log_item($id,$project_id,$name){
		if($this->Authorization->checkAuthorization($project_id) < 0){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
		
		$this->Todo->id = $id;
		$this->set('current', $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order'))));
		$this->set('history', $this->Todo->revisions());
		
		// create a custom title for the page
		App::import('Helper', 'Html');
		$html = new HtmlHelper();
		$this->set('custom_title', '<a href="'.$html->url(array("action" => "todolist",$project_id,$name)).'">Item log</a>');
	}
	
	/**
	* Update the color of one Todo item
	*/
	function color($id){
		$item = $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order')));

		if($this->Authorization->checkAuthorization($item['Todo']['project_id']) < 2){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
		
		$color = $_POST['color'];

		$item['Todo']['color'] = $color;
		unset($item['Todo']['modified']);
		$this->Todo->save($item);
		$item = $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order')));		
		exit;
	}
	
	/**
	* Update the order of all todo items 
	* TODO: this can be done more efficiently
	*/
	function order($project_id){
		if($this->Authorization->checkAuthorization($project_id) < 2){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}

		$current_item_id = $_POST['item'];
		for ($status=1; $status < 4; $status++) { 
			// get the post variable for the current status
			$idString = $_POST['column'.$status];

			// if there is no todo in the string please continue
			if(strlen($idString) < 1) continue;
			
			// split the ids
			$ids = split(',',$idString);
			
			// first item has order 0
			$order_number = 0;
			foreach ($ids as $id) {

				// get the item from the database (this could be optimized!)
				$item = $this->Todo->find('first', array('conditions' => array('id' => $id),'order' => array('order')));
				
				//if it's a valid item go on
				if($item){
					// if the order or the status changed go on
					if($item['Todo']['order'] != $order_number || $item['Todo']['status'] != $status){

						// set the order and the status
						$item['Todo']['order'] = $order_number;
						$item['Todo']['status'] = $status;

						// if this item is the dragged item, reset the modified date
						if($item['Todo']['id'] === $current_item_id){
							unset($item['Todo']['modified']);
						}
						
						// save it to the database
						$this->Todo->save($item);
					}
				}
				$order_number++;
			}
			
		}
		exit;
	}
	
	
	/**
	* Remove a todo item from a list
	*/		
	function remove($id,$project_id,$name){
		if($this->Authorization->checkAuthorization($project_id) < 2){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
		
		$this->Todo->delete($id);
		$this->redirect(array('action' => 'todolist',$project_id,$name));
		exit;
	}

	/**
	* Update the text of a todo item
	*/	
	function update($project_id,$name){
		if($this->Authorization->checkAuthorization($project_id) < 2){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
		
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
	
	/**
	* Update the status of a todo item
	*/
	function updateStatus($id,$new_status,$project_id,$name){
		if($this->Authorization->checkAuthorization($project_id) < 2){
			// redirect back to the login page
			$this->Session->setFlash('This method requires a login');
			$this->redirect(array('action' => 'login',$project_id,$name));
			exit;
		}
		
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
	
	/**
	* The user doesn't want to see all complete items in the list
	*/
	function less() {
		$this->Session->write('more',false);
		$this->redirect($this->referer());
		exit;
	}

	/**
	* The user doesn't want to see all complete items in the list
	*/
	function more() {
		$this->Session->write('more',true);
		$this->redirect($this->referer());
		exit;
	}
	
}
?>
