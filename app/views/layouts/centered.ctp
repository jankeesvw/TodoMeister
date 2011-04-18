<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en" id="html_centered"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en" id="html_centered"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en" id="html_centered"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en" id="html_centered"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php echo $title_for_layout ?></title>

        <meta name="description" content="Todomeister is the simplest way to create collaborative todo lists to share with your team. ">
        <meta name="author" content="Jankees van Woezik, Base 42, @jankeesvw">

        <link rel="shortcut icon" href="<?php echo $this->Html->url("/favicon.ico"); ?>">

        <link rel="apple-touch-icon-precomposed" href="<?php echo $this->Html->url("/apple-touch-icon-57x57.png"); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->Html->url("/apple-touch-icon-72x72.png"); ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->Html->url("/apple-touch-icon-114x114.png"); ?>">

        <?php
        echo $html->css('style.css?v=2');
        echo $html->css('todomeister.css?v=2');
        echo $html->css('colorPicker.css');


        if (isset($javascript)) {
        echo $javascript->link('libs/modernizr-1.7.min.js');
        echo $javascript->link('libs/jquery-1.5.1.js');
        echo $javascript->link('libs/dd_belatedpng.js');
        echo $javascript->link('libs/jquery.colorPicker.js');
        echo $javascript->link('script.js');
        echo $scripts_for_layout;
        }
        ?>

        <?php if (Configure::read('TodoMeister.show_feedback') !== false) {  ?>
        <style type='text/css'>@import url('http://getbarometer.s3.amazonaws.com/assets/barometer/css/barometer.css');</style>
        <script src='http://getbarometer.s3.amazonaws.com/assets/barometer/javascripts/barometer.js' type='text/javascript'></script>
        <script type="text/javascript" charset="utf-8">
            BAROMETER.load('x1fMasXW2Z2t3bT2G4cZj');
        </script>
        <?php } ?>
    </head>
    <body class="centered">

        <div id="centered" role="main">
            <?php $error = $this->Session->flash(); ?>
            <?php if ($error != "") {
 ?>
                <div class="error">
<?php echo $error; ?>
            </div>
            <?php } ?>
<?php echo $content_for_layout ?>
        </div>
    </body>
</html>
