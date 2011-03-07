<div class="logs">
	<?php 
	
			if(sizeof($revs) > 0){
				$current_id = $revs[0]['Todo']['id'];
				echo "<br/>";
				echo $this->Todo->renderLogHeader($revs[0]);
			}
			
			foreach ($revs as $rev) {

				if($current_id != $rev['Todo']['id']){

					echo "<div style=\"clear: both;\"></div>";
					echo "<br>";
					echo $this->Todo->renderLogHeader($rev);
					$current_id = $rev['Todo']['id'];
				}
				echo $this->Todo->renderLog($rev);
			} 
		?>
</div>
