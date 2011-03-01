You are probably on this page because you wanted to create or see a todolist.. Are you looking for a login or register button?<br>
That's not how todomeister works :). The main goal of Todomeister is to keep it simple! So no login and registration!!<br>
<br>
Just pick a project name, give your name and get started<br><br>
<form method="post" action="<?php echo $this->Html->url(array("action" => "start"));?>">
	<div class="label">Project name:</div><input type="text" value="<?php echo $project_id; ?>" name="projectname" class="start input"/><br><br>
	<div class="label">Your name:</div><input type="text" name="username" class="start input"/><br><br>
	<br>
	<input type="submit" class="button" value="Let's get started" />
</form>
