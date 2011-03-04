<div class="column logs">
	<table>
	<tr>
		<td>
	<?php 
			if(sizeof($revs) > 0){
				$current_id = $revs[0]['Todo']['id'];
				echo "<br/>";
				echo $this->Todo->renderLogHeader($revs[0]);
				echo "<br/>";
			}
			
			foreach ($revs as $rev) {
				if($current_id != $rev['Todo']['id']){
					echo "</td></tr><tr><td><br/><br/>";
					echo $this->Todo->renderLogHeader($rev);
					echo "<br/>";
					$current_id = $rev['Todo']['id'];
				}
				echo $this->Todo->renderLog($rev);
			} 
		?>
		</td>
	</tr>
	<table>

</div>
