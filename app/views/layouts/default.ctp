<html>
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title><?php echo $title_for_layout?></title>
		<?php echo $scripts_for_layout; ?>
		<?php echo $html->css('reset.css')?>
		<?php echo $html->css('tool.css')?>
		<?php echo $html->css('colorPicker.css')?>
		<?php 
		if (isset($javascript)){
			echo $javascript->link('jquery-1.4.4.min.js');
			echo $javascript->link('jquery-ui-1.8.9.custom.min.js');
			echo $javascript->link('jquery.colorPicker.js');
		}
		?>
	</head>
	<?php
		if (isset($javascript)){
	?>
	<script>
		$.fn.colorPicker.defaultColors =  ['BE7CBA','6460AF','83AFDC','3A804A','3A804A','E9EB4A','F4AE48','EB3D36','A8773E'];
		
	    $(function() {
			//create color picker	
			$('.color').colorPicker();
			updateColorPickers();
		});
		
		function updateColorPickers(){
		  $('.color_picker').each(function(index) {
			$(this).height($(this).parent().first().height()+8+5);
		  });
		}		
	</script>
	<?php
		}
	?>

	<body>
		<div class="header">
			<h1 class="title"><abbr title="version v1" ><a href="<?php echo $this->Html->url(array("action" => "start"));?>">todomeister</a><abbr> <p>(by <a href="http://www.base42.nl">base42.nl</a>)</p></h1>
			<?php if(isset($project_id) && !isset($custom_title)){ ?>
				<h1><a href="<?php echo $this->Html->url(array("action" => "logs",$project_id,$name));?>"><?php echo $project_id; ?></a> <p>(user: <?php echo $name; ?>)</p></h1>			
			<?php }else if(isset($custom_title)){ ?>
				<h1 class="project_title"><?php echo $custom_title; ?></h1>			
			<?php }else { ?>
				<h1 class="project_title">Hi!</h1>			
			<?php } ?>
		</div>
		<div class="hr"></div>
		<?php $error = $this->Session->flash(); ?>
		<?php if ($error != "") {?>
			<div class="error">
			   	<?php echo $error; ?>
			</div>
		<?php } ?>
		
		<?php echo $content_for_layout ?>
		<div style="clear: both;"></div>
	</body>
</html>