<div class="column logs">
	<ul class="logs">
		<?php 
			$current_day = date("Ymj");
			$firstround = true;
			foreach ($revs as $rev) { ?>
			<?php
				if($firstround || $current_day != date("Ymj", strtotime($rev['Todo']['modified']))){
					if(!$firstround) echo "<div class='hr' /><br />";
					echo date("l, j F Y", strtotime($rev['Todo']['modified']))."<br /><br />";
				}
				$current_day = date("Ymj", strtotime($rev['Todo']['modified']));
				$firstround = false;
			?>
			<?php echo $this->Todo->renderLog($rev); ?>
		<?php } ?>
	</ul>
</div>
