<h2>List of all <?php echo count($lists); ?> todo lists on this server</h2>
<ul>
<?php
	foreach ($lists as $list) {
		echo "<li><a href=\"".$this->Html->url(array("action" => "todolist",$list['Todo']['project_id']))."\">".$list['Todo']['project_id']."</a> (".$list[0]['count']." todos)</li>";
	}
?>
</ul>