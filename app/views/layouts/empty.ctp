<!doctype html>
<html lang="en">
	<body>
		<?php $error = $this->Session->flash(); ?>
		<?php if ($error != "") {?>
		<div class="error">
		   	<?php echo $error; ?>
		</div>
		<?php } ?>
		<?php echo $content_for_layout ?>
	</body>
</html>