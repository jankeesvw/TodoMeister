<div id="home">
	<?php if($project_id === ""){ ?>
		<h2>Welcome to <em><abbr title="version <?php echo Configure::read('TodoMeister.version'); ?>">Todomeister</abbr></em></h2>	
		Todomeister is the simplest way to create <ins>collaborative todo lists</ins> to <ins>share</ins> with your team. <br><br>
		The main goal of Todomeister is to keep it simple! So <ins>no login</ins> and <ins>no registration</ins> required.<br>
		<br>
		Just pick a project name fill in your name and get started<br>
		<script>
			$(function() {
				$('#projectname').focus();
			});
		</script>
	<?php }else{ ?>
		Please fill in <strong>your name</strong> below to work on: <br><br><ins><?php echo $project_id; ?></ins><br>
		<script>
			$(function() {
				$('#username').focus();
			});
		</script>	
	<?php } ?>
	<form method="post" action="<?php echo $this->Html->url(array("action" => "start"));?>">
		<label for="projectname">Project name:</label>
		<input autocomplete="off" style="float: left;" type="text" name="projectname" value="<?php echo $project_id; ?>" class="start input" id="projectname">
		<div id="project_name_availability">
			<span id="loading" class="hidden"><img src="<?php echo $this->Html->url("/img/loading.gif");?>" > <p>loading</p></span>
			<span id="available" class="hidden"><img src="<?php echo $this->Html->url("/img/available.jpg");?>" > <p>available</p></span>
			<span id="taken" class="hidden"><img src="<?php echo $this->Html->url("/img/taken.png");?>" > <p>Sorry, taken</p></span>
		</div>
		
		<div style="clear: both;"></div>		
		<label for="username">Your name:</label><input autocomplete="off" type="input" name="username" id="username">
		<br>
		<input type="submit" class="button" value="Let's get started">

	</form>
	<?php if(Configure::read('TodoMeister.build_index') === true){ ?>
		<br>
		<a href="<?php echo $this->Html->url(array("action" => "list_index"));?>">todo list index</a>
	<?php } ?>
</div>
<script>
	var timeOut;
	$(function() {
		$('#projectname').keyup(function() {

			$('#project_name_availability').find('#taken').addClass('hidden');			
			$('#project_name_availability').find('#available').addClass('hidden');			
			$('#project_name_availability').find('#loading').removeClass('hidden');
			
			
			if(timeOut) clearTimeout(timeOut);
			timeOut = setTimeout(checkAvailablity, 1000);

			
		});
		
		function checkAvailablity(){
			$('#project_name_availability').find('#taken').addClass('hidden');			
			$('#project_name_availability').find('#available').addClass('hidden');			
			$('#project_name_availability').find('#loading').removeClass('hidden');
			
			$.ajax({
			   type: "POST",
			   url: '<?php echo $this->Html->url(array("action" => "list_name_available"));?>/'+$('#projectname').attr('value'),
			   success: function(html){
					if(html == "1"){
						$('#project_name_availability').find('#available').addClass('hidden');			
						$('#project_name_availability').find('#loading').addClass('hidden');						
						$('#project_name_availability').find('#taken').removeClass('hidden');									
					}else{
						$('#project_name_availability').find('#available').removeClass('hidden');			
						$('#project_name_availability').find('#loading').addClass('hidden');						
						$('#project_name_availability').find('#taken').addClass('hidden');						
					}

				}
			 });
		}
	});
</script>