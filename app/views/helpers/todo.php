<?php
	class TodoHelper extends AppHelper {
			var $helpers = array('Html','RelativeTime');
			
			function form($status,$url,$project_id,$name) {
					$form = "";
					$form .= " <div class=\"twinForm\">                                                                                     ";
					$form .= " 	<form method=\"post\" action=\"".$url."\">                                                              ";
					$form .= " 		<input type=\"text\" name=\"data[Todo][text]\" class=\"input\"/>                                    ";
					$form .= " 		<input type=\"hidden\" name=\"data[Todo][project_id]\" value=\"".$project_id."\" class=\"input\"/>  ";
					$form .= " 		<input type=\"hidden\" name=\"data[Todo][who]\" value=\"".$name."\" class=\"input\"/>             ";
					$form .= " 		<input type=\"hidden\" name=\"data[Todo][status]\" value=\"".$status." \" class=\"input\"/>          ";
					$form .= " 		<input type=\"submit\" class=\"button\" value=\"add\" />                                             ";
					$form .= " 	</form>                                                                                                 ";
					$form .= " </div>                                                                                                   ";
					return $form;
			}
			
			function todo($data,$project_id="",$name="",$auth_level=-1) {
				$current_status = $data['Todo']['status'];
							
				$editlinks = "";
				
				$editlinks .= "<span class=\"statusBased visibleOnStatus1\">";
				$editlinks .= "<a href=\"#\" class=\"edit_button\">edit</a> - "; 
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "remove", $data['Todo']['id'],$project_id,$name))."\">remove</a> - ";
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status+1,$project_id,$name))."\">start</a>"; 
				$editlinks .= "</span>";
				
				$editlinks .= "<span class=\"statusBased visibleOnStatus2\">";
				$editlinks .= "<a href=\"#\" class=\"edit_button\">edit</a> - "; 
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status-1,$project_id,$name))."\">stop</a> - "; 
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status+1,$project_id,$name))."\">done</a>"; 
				$editlinks .= "</span>";
				
				$editlinks .= "<span class=\"statusBased visibleOnStatus3\">";
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],$current_status-1,$project_id,$name))."\">put back</a> - "; 
				$editlinks .= "<a href=\"".$this->Html->url(array("action" => "log_item", $data['Todo']['id'],$project_id,$name))."\">show log</a>";
				$editlinks .= "</span>";
				
				if($auth_level < 2) $editlinks = ""; 
				
				$date = "";
				$date .= "<span>";
				$date .= $data['Todo']['who'];
				$date .= " </span>";
				$date .= "<span class=\"statusBased visibleOnStatus1 visibleOnStatus2\">";
				$date .= "<a id=\"time\" href=\"".$this->Html->url(array("action" => "log_item", $data['Todo']['id'],$project_id,$name))."\">(".$this->RelativeTime->getRelativeTime($data['Todo']['modified'])." ago)</a>";
				$date .= "</span>";
				
				?>
					<li class="<?php echo $current_status != "3" ? "editable" : ""; ?> todo" id="<?php echo $data['Todo']['id']; ?>">
						
						<?php if($auth_level > 2) { ?>
							<input autocomplete="off" class="hidden color_picker" name="<?php echo $data['Todo']['id']; ?>" value="<?php echo $data['Todo']['color']; ?>" />
						<?php }else{ ?>
							<div class="color" style="background-color: <?php echo $data['Todo']['color']; ?>;">&nbsp;</div>
						<?php } ?>						
						<sub class="actions right"> <?php echo $editlinks; ?> </sub>
						<p class="original hidden"><?php echo $data['Todo']['text']; ?></p>
						<p><?php echo nl2br($data['Todo']['text']); ?></p>
						<sub class="footer"><?php echo $date; ?></sub>
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
				<div class="logitem status<?php echo $data['Todo']['status']; ?>">
					<div class="todo">
						<div class="color" style="background-color: <?php echo $data['Todo']['color']; ?>;">&nbsp;</div>
						<p><?php echo nl2br($data['Todo']['text']); ?></p>
						<sub class="footer"><?php echo $sinceTime; ?></sub>
					</div>
				</div>
				<?php
			}
	}
?>