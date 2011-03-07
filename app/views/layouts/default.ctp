<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php echo $title_for_layout?></title>

  <meta name="description" content="Todomeister is the simplest way to create collaborative todo lists to share with your team. ">
  <meta name="author" content="Jankees van Woezik, Base 42, @jankeesvw">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="<?php echo $this->Html->url("/favicon.ico");?>">
  <link rel="apple-touch-icon" href="<?php echo $this->Html->url("/apple-touch-icon.png");?>">

<?php
 	echo $html->css('style.css?v=2');
 	echo $html->css('todomeister.css?v=2');
 	echo $html->css('colorPicker.css');

	if (isset($javascript)){
		echo $javascript->link('libs/modernizr-1.7.min');
		echo $javascript->link('libs/jquery-1.5.1');
		echo $javascript->link('libs/dd_belatedpng');
		echo $javascript->link('libs/jquery.colorPicker');
		echo $javascript->link('script');		
		echo $scripts_for_layout;
	}
?>
</head>
	<body id="todomeister">
		<header>
			<div class="right">
				<h1><abbr title="version <?php echo Configure::read('TodoMeister.version'); ?>"><a href="<?php echo $this->Html->url(array("action" => "start"));?>">todomeister</a></abbr></h1>
				<sub class="tiny"><a href="http://www.base42.nl">(by base42.nl)</a></sub>
			</div>
			<div>
				<h1><?php echo isset($custom_title) ? $custom_title : "hello"; ?></h1>
				<sub><?php echo isset($custom_sub_title) ? $custom_sub_title : "&nbsp;"; ?></sub>
			</div>	
			<hr>
	    </header>
		
		<?php $error = $this->Session->flash(); ?>
		<?php if ($error != "") {?>
		<div class="error">
		   	<?php echo $error; ?>
		</div>
		<?php } ?>
	
    	<div id="main" role="main">
			<?php echo $content_for_layout ?>
		</div>
		
		<div style="clear: both;"></div>
	</body>
</html>