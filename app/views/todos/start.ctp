<div id="home">
	<?php if($project_id === ""){ ?>
	<h2>Welcome to <em><abbr title="version <?php echo Configure::read('TodoMeister.version'); ?>">Todomeister</abbr></em></h2>	
	Todomeister is the simplest way to create <ins>collaborative todo lists</ins> to <ins>share</ins> with your team. <br><br>
	The main goal of Todomeister is to keep it simple! So <ins>no login</ins> and <ins>no registration</ins> required.<br>
	<br>
	Just pick a project name fill in your name and get started<br>
	<?php }else{ ?>
	Please fill in <strong>your name</strong> below to work on: <br><br><ins><?php echo $project_id; ?></ins><br>
	
	<script>
		$(function() {
			$('#username').focus();
		});
	</script>
	
	<?php } ?>
	<form method="post" action="<?php echo $this->Html->url(array("action" => "start"));?>">
		<label for="projectname">Project name:</label><input type="text" name="projectname" value="<?php echo $project_id; ?>" class="start input" id="projectname">
		<label for="username">Your name:</label><input type="input" name="username" id="username">
		<br>
		<input type="submit" class="button" value="Let's get started">
	</form>
	<?php if(Configure::read('TodoMeister.build_index') === true){ ?>
		<br>
		<a href="<?php echo $this->Html->url(array("action" => "list_index"));?>">todo list index</a>
	<?php } ?>
</div>