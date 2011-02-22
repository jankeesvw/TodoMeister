<div class="column logs">
		<table>
			<tr>
				<td>

		<?php 
			if(sizeof($revs) > 0) $current_id = $revs[0]['Todo']['id'];
			foreach ($revs as $rev) {
				
				if($current_id != $rev['Todo']['id']){
					echo "</td><td style='vertical-align: top;'>";
					$current_id = $rev['Todo']['id'];
				}
				echo $this->Todo->renderLog($rev);
			} 
		?>	</td>
			</tr>
		</table>

</div>
