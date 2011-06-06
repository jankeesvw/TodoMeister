<?php

   App::import('Sanitize');

	class Todo extends AppModel {
	   
	    var $name = 'Todo';
		var $actsAs = array('Revision' => array('ignore'=>array('modified','order','color')));
	    var $validate = array(
		 	'text' => array(
	            'rule' => array('minLength', '1')
	        ),
		 	'project_id' => array(
	            'rule' => array('minLength', '1')
	        ),
		 	'who' => array(
		        'rule' => array('minLength', '1')
		    ),

	    );

           // TODO: FIX this!
      /*	    
	    function beforeSave()
        {
            
           //          $this->data['Todo']['text'] = Sanitize::clean($this->data['Todo']['text']);
           //          $this->data['Todo']['who'] = Sanitize::clean($this->data['Todo']['who']);
          return true;
        }*/
		
	}

?>
