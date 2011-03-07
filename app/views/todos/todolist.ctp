<?php

	$js_vars = "";
	$js_vars .= "var head_title = '". $project_id . " - " .$name ." [" .count($statusOne) .", ". count($statusTwo) .",". count($statusThree) . "]';";
	$js_vars .= "var version_url = '".$this->Html->url(array("action" => "version",$project_id))."';";
	$js_vars .= "var color_update_url = '".$this->Html->url(array("action" => "color"))."';";
	$js_vars .= "var text_update_url = '".$this->Html->url(array("action" => "update",$project_id,$name))."';";
	$js_vars .= "var order_update_url = '".$this->Html->url(array("action" => "order",$project_id))."';";	

	echo $this->Javascript->codeBlock($js_vars); 


	if($auth_level > 1) { 
		echo $this->Javascript->includeScript('todolist-editable');
		echo $this->Javascript->link('libs/jquery-ui-1.8.10.custom.min');
	} 
	echo $this->Javascript->includeScript('todolist');

?>

<div id="main" role="main">
	<div class="column status1"> 
		<h2>todo (<span class="numberOfTodos"><?php echo count($statusOne); ?></span>)</h2>
 		<?php 
		if($auth_level > 1) { 
			echo $this->Todo->form("1",$this->Html->url(array("action" => "add",$project_id,$name)),$project_id,$name);
		}
		?>
		<ul class="sortable">
			<?php foreach ($statusOne as $status) { ?>
				<?php echo $this->Todo->todo($status,$project_id,$name,$auth_level); ?>
			<?php } ?>
		</ul>
	</div>
	<div class="column status2"> 
		<h2>in progress (<span class="numberOfTodos"><?php echo count($statusTwo); ?></span>)</h2>
	 	<?php 
			if($auth_level > 1) {
				 echo $this->Todo->form("2",$this->Html->url(array("action" => "add",$project_id,$name)),$project_id,$name);
			}
		?>
		<ul class="sortable">
			<?php foreach ($statusTwo as $status) { ?>
				<?php echo $this->Todo->todo($status,$project_id,$name,$auth_level); ?>
			<?php } ?>
		</ul>
	</div>
	<div class="column status3"> 
		<h2>done (<span class="numberOfTodos"><?php echo count($statusThree); ?></span>)</h2>
		<ul class="sortable">
			<?php 
				$iterator = 0;
				foreach ($statusThree as $status) { 
					$iterator++;
					if($iterator < 10 || $this->Session->read('more') == 1){
						echo $this->Todo->todo($status,$project_id,$name,$auth_level); 
					}else{ 
						?>	<div class="more"><a href="<?php echo $this->Html->url(array("action" => "more"));?>">more...</a></div><?php 
					break;
					}
				}
				if($iterator > 10 && $this->Session->read('more') == 1){
					?>	<div class="more"><a href="<?php echo $this->Html->url(array("action" => "less"));?>">less...</a></div><?php 	
				}
			?>
		</ul>
	</div>
</div>
</div>
