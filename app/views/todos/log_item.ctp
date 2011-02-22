<div class="column">
	<ul>
		<?php echo $this->Todo->renderLog($current); ?>
		<?php foreach ($history as $log) { ?>
			<?php echo $this->Todo->renderLog($log); ?>
		<?php } ?>
	</ul>
</div>
