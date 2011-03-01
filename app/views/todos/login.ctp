<h2>Please, fill in your password.</h2>
<br>

<?php echo $form->create('Password', array('url' => array('controller' => 'Todos', 'action' => 'login',$project_id,$name))) ?>
<?php echo $form->password('password') ?>
<?php echo $form->end('login') ?>