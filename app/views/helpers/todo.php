<?php
	class TodoHelper extends AppHelper {
			var $helpers = array('Html','RelativeTime');
			
			function render($data,$project_id="",$name="",$auth_level=-1) {
				$current_status = $data['Todo']['status'];
							
				$editlinks = "";
				
				$editlinks .= "<span class=\"link_status_1 dynamic\">";
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "remove", $data['Todo']['id'],$project_id,$name))."\">remove</a> - ";
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status+1,$project_id,$name))."\">start</a>"; 
				$editlinks .= "</span>";
				
				$editlinks .= "<span class=\"link_status_2 dynamic\">";
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status-1,$project_id,$name))."\">stop</a> - "; 
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status+1,$project_id,$name))."\">done</a>"; 
				$editlinks .= "</span>";
				
				$editlinks .= "<span class=\"link_status_3 dynamic\">";
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status-1,$project_id,$name))."\">put back</a> - "; 
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "log_item", $data['Todo']['id'],$project_id,$name))."\">show log</a>";
				$editlinks .= "</span>";
				
				if($auth_level < 2) $editlinks = ""; 
				
				$date = "";
				$date .= "<span class=\"link_status_1 link_status_2 link_status_3 dynamic\">";
				$date .= $data['Todo']['who'];
				$date .= " </span>";
				$date .= "<span class=\"link_status_1 link_status_2 dynamic\">";
				$date .= "<a id=\"time\" href=\"".$this->Html->url(array("action" => "log_item", $data['Todo']['id'],$project_id,$name))."\">(".$this->RelativeTime->getRelativeTime($data['Todo']['modified'])." ago)</a>";
				$date .= "</span>";
				
				?>
					<li id="<?php echo $data['Todo']['id']; ?>" class="background">						
						<input autocomplete="off" id="color1" class="color" type="hidden" name="<?php echo $data['Todo']['id']; ?>" value="<?php echo $data['Todo']['color']; ?>" />
						<p class="actions"> <?php echo $editlinks; ?> </p>
						<p class="original"><?php echo $data['Todo']['text']; ?></p>
						<p class="todo <?php if($current_status < 3) { echo "editable"; }?>"><?php echo nl2br($data['Todo']['text']); ?></p>
						<p class="author"><?php echo $date; ?></p>
					</li>
				<?php
			}
			
			function renderLogHeader($data) {
				return "<p>'". $data['Todo']['text'] . "' created by ". $data['Todo']['who'] ." (".$this->RelativeTime->getRelativeTime($data['Todo']['modified'])." ago)</p>";
			}
			
			function renderLog($data) {
				$sinceTime = strtotime($data['Todo']['modified'])-strtotime($data['Todo']['created']);
				if($sinceTime == 0){
					$sinceTime = "created by ". $data['Todo']['who']  ." on " .date("F j, Y H:i", strtotime($data['Todo']['modified']));
				}else{
					if($data['Todo']['status'] === "3"){
						$sinceTime = "closed by ". $data['Todo']['who']  ." " .$this->RelativeTime->relativeTime($sinceTime) . " after creation";
					}else{
						$sinceTime = "edited by ". $data['Todo']['who']  ." " .$this->RelativeTime->relativeTime($sinceTime) . " after creation";
					}
					
				}
				
				?>
					<li class="background status<?php echo $data['Todo']['status'];?>">
						<div class="color_picker" style="background-color: <?php echo $data['Todo']['color'];?>">&nbsp;</div>
						<p class="todo"><?php echo nl2br($data['Todo']['text']); ?></p>
						<p class="author"><?php echo $sinceTime;?></p>
					</li>
				<?php
			}
	}
?>