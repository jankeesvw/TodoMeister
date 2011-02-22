<?php
	class TodoHelper extends AppHelper {
			var $helpers = array('Html','RelativeTime');
	 
			function render($data,$project_id="",$name="") {
				$current_status = $data['Todo']['status'];
				
				$editlinks = "";
				
				switch ($current_status) {
					case '1':
						$editlinks .= "<a href=\"".$this->Html->url(array("action" => "remove", $data['Todo']['id'],$project_id,$name))."\">remove</a> - ";
						$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status+1,$project_id,$name))."\">start</a>"; 
						break;
					case '2':
						$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status-1,$project_id,$name))."\">stop</a> - "; 
						$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status+1,$project_id,$name))."\">done</a>"; 
						break;
					case '3':
						$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status-1,$project_id,$name))."\">put back</a> - "; 
						$editlinks .= "<a href=\"".$this->Html->url(array("action" => "log_item", $data['Todo']['id'],$project_id,$name))."\">show log</a>";
						break;
				}
				
				?>
					<li id="<?php echo $data['Todo']['id']; ?>" class="background status<?php echo $current_status;?>">
						<input autocomplete="off" id="color1" class="color" type="hidden" name="<?php echo $data['Todo']['id']; ?>" value="<?php echo $data['Todo']['color']; ?>" />
						<p class="todo <?php if($current_status < 3) { echo "editable"; }?>"><?php echo nl2br($data['Todo']['text']); ?></p>
						<p class="author"><?php echo $data['Todo']['who']; ?> <?php if($current_status < 3){ ?><a href="<?php echo $this->Html->url(array("action" => "log_item", $data['Todo']['id'],$project_id,$name));?>">(<?php echo $this->RelativeTime->getRelativeTime($data['Todo']['modified']);?>)</a><?php }; ?></p>
						<p class="actions"> <?php echo $editlinks; ?> </p>			
					</li>
				<?php
			}
			function renderLog($data) {
				?>
					<li class="background status<?php echo $data['Todo']['status'];?>">
						<div class="color_picker" style="background-color: <?php echo $data['Todo']['color'];?>">&nbsp;</div>
						<p class="todo"><?php echo nl2br($data['Todo']['text']); ?></p>
						<p class="author"><?php echo $data['Todo']['who']; ?> (<?php echo $this->RelativeTime->getRelativeTime($data['Todo']['modified']);?>)</p>
					</li>
				<?php
			}
	}
?>