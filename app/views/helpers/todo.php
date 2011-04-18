<?php
	class TodoHelper extends AppHelper {
			var $helpers = array('Html','RelativeTime');
			
			function form($status,$url,$project_id,$name) {
					$form = "";
					$form .= " <div class=\"twinForm\">                                                                                     ";
					$form .= " 	<form method=\"post\" action=\"".$url."\">                                                              ";
					$form .= " 		<input autocomplete=\"off\" type=\"text\" name=\"data[Todo][text]\" class=\"input\"/>                                    ";
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
				
				$editlinks .= "<ul class=\"statusBased visibleOnStatus1\">";
				$editlinks .= "<li><a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],2,$project_id,$name))."\">".$this->Html->image('arrow1_e.png')."</a></li>"; 
				$editlinks .= "<li><a href=\"#\" class=\"edit_button\">".$this->Html->image('edit.png')."</a></li>"; 
				$editlinks .= "<li><a href=\"".$this->Html->url(array("action" => "remove", $data['Todo']['id'],$project_id,$name))."\">".$this->Html->image('trash.png')."</a></li>";
				$editlinks .= "</ul>";
				
				$editlinks .= "<ul class=\"statusBased visibleOnStatus2\">";

				$editlinks .= "<li><a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],3,$project_id,$name))."\">".$this->Html->image('arrow1_e.png')."</a></li>"; 
				$editlinks .= "<li><a href=\"#\" class=\"edit_button\">".$this->Html->image('edit.png')."</a></li>"; 
				$editlinks .= "<li><a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],1,$project_id,$name))."\">".$this->Html->image('arrow1_w.png')."</a></li>"; 
				$editlinks .= "</ul>";
				
				$editlinks .= "<ul class=\"statusBased visibleOnStatus3\">";
				$editlinks .= "<li><a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],2,$project_id,$name))."\">".$this->Html->image('arrow1_w.png')."</a></li>"; 
				$editlinks .= "<li><a href=\"".$this->Html->url(array("action" => "updateStatus", $data['Todo']['id'],4,$project_id,$name))."\">".$this->Html->image('arrow1_e.png')."</a></li>"; 
				$editlinks .= "</ul>";
				
				if($auth_level < 2) $editlinks = ""; 
				
				$date = "";
				$date .= "<span id=\"user\">";
				$date .= $data['Todo']['who'];
				$date .= "</span> ";
				$date .= "<span class=\"statusBased visibleOnStatus1 visibleOnStatus2\">";
				$date .= "<a id=\"time\" href=\"".$this->Html->url(array("action" => "log_item", $data['Todo']['id'],$project_id,$name))."\">(updated ".$this->RelativeTime->getRelativeTime($data['Todo']['modified']).")</a>";
				$date .= "</span>";
				
				?>
					<li class="<?php echo $current_status != "3" ? "editable" : ""; ?> todo" id="<?php echo $data['Todo']['id']; ?>">
						
						<?php if($auth_level > 1) { ?>
							<input autocomplete="off" class="hidden color_picker" name="<?php echo $data['Todo']['id']; ?>" value="<?php echo $data['Todo']['color']; ?>" />
						<?php }else{ ?>
							<div class="color" style="background-color: <?php echo $data['Todo']['color']; ?>;">&nbsp;</div>
						<?php } ?>						
						<div class="actions"> <?php echo $editlinks; ?> </div>
						<p class="original hidden"><?php echo $data['Todo']['text']; ?></p>
						<p class="text"><?php echo nl2br($data['Todo']['text']); ?></p>
						<sub class="footer statusBased visibleOnStatus1 visibleOnStatus2"><?php echo $date; ?></sub>
					</li>
				<?php
			
			}
			
			function shortenText($text,$length=25) {
			        $chars = $length;
			        $text = $text." ";
			        $text = substr($text,0,$chars);
			        $text = substr($text,0,strrpos($text,' '));
			        $text = $text."...";
					return $text;
    		}
			
			
			function renderLogHeader($data) {
				return "<p>'". $this->shortenText($data['Todo']['text'],40) . "' created by ". $data['Todo']['who'] ." (".$this->RelativeTime->getRelativeTime($data['Todo']['modified']).")</p>";
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