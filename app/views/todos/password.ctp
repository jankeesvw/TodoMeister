<?php echo $form->create('Password', array('url' => array('controller' => 'Todos', 'action' => 'password',$project_id,$name))) ?>
<?php echo $form->input('id') ?>
<?php echo $form->input('read',array('label'=>'Read only password')) ?>
<?php echo $form->input('read-write',array('label'=>'Read and write password','style'=>'width: 200px')) ?>
<?php echo $form->end(array( 'label' => 'Save passwords', 'value' => 'save passwords', 'div' => array('class' => 'button'))); ?>