<?php

	class Todo extends AppModel {
	    var $name = 'Todos';
		var $actsAs = array('Revision' => array('ignore'=>array('modified','order')));
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
		
	}

?>
