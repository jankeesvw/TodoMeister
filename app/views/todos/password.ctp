<h2><em>Password protection</em></h2>
<p>To secure your list you can create a password. Fill in the form below.
<br><br>
<?php echo $this->Html->link("Click here to remove your password.", array("action"=>"remove_password",$project_id,$name));?>

</p>
<?php echo $form->create('Password', array('url' => array('controller' => 'Todos', 'action' => 'password',$project_id,$name))) ?>
<?php echo $form->input('id') ?>

<?php echo $form->input('read-write',array('label'=>'Password','style'=>'width: 200px','autocomplete'=>"off")) ?>

<input id="checkboxforreadpassword" type="checkbox" name="wantreadpassword" style="float: left; display: inline;">
<label for="wantreadpassword" style="float: left; display: inline;">I would like to create a <strong>viewers password</strong></label>

<div style="clear: both;"></div>

<div id="readonlypassword">
	<?php echo $form->input('read',array('label'=>'Read only password (optional)','style'=>'width: 200px','autocomplete'=>"off")) ?>
</div>

<?php echo $form->end(array( 'label' => 'Set passwords', 'value' => 'save passwords', 'div' => array('class' => 'button'))); ?>

<script>
	
	$(function() {
		
		$('#PasswordRead').attr('value','');
		$('#PasswordRead-write').attr('value','');
	
		function updateViewToCheckbox(){
			if($('#checkboxforreadpassword').attr('checked')){
				$('#readonlypassword').slideDown();
			}else{
				//empty and hide
				$('#PasswordRead').attr('value','');
				$('#readonlypassword').slideUp();
			}
		}

		$('#checkboxforreadpassword').click(function() {
			updateViewToCheckbox();
		});
	
		$('#readonlypassword').hide();
		$('#PasswordRead').attr('value','');
		
	});
</script>