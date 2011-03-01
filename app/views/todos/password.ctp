<?php echo $form->create('Password', array('url' => array('controller' => 'Todos', 'action' => 'password',$project_id,$name))) ?>
<?php echo $form->input('id') ?>
<?php echo $form->input('read') ?>
<?php echo $form->input('read-write') ?>
<?php echo $form->end(array( 'label' => 'Save passwords', 'value' => 'save passwords', 'div' => array('class' => 'button'))); ?>