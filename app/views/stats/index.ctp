<h1>Stats for <em>Todomeister</em></h1>
<br>
<h2>Number of todos: <ins><?php echo $numberOfTodos; ?></ins></h2>
<h2>Number of todos created today: <ins><?php echo $numberOfTodosToday; ?></ins></h2>
<h2>Number of lists: <ins><?php echo $numberOfLists; ?></ins></h2>
<h2>Number of passwords: <ins><?php echo $numberOfPasswords; ?></ins></h2>
<h2>Number of users: <ins><?php echo $numberOfUsers; ?></ins></h2>
<br>
<h2>Protectiveness:</h2>
<?php
	$number_of_unprotected = $numberOfLists - $numberOfPasswords;
	echo $this->Chart->pieChart(array($number_of_unprotected,$numberOfPasswords),array("Unprotected: " . $number_of_unprotected,"Protected: " . $numberOfPasswords)," ");
?>
<br><br>
<h2>Todos created per day:</h2>
<?php
	
	$counts = array();
	$days = array();
	foreach ($createdItemsPerDay as $day) {
		$count = $day[0]['count'];
		$created_day = $day[0]['created_day'];
		array_push($counts,$count);
		array_push($days,$created_day);
	}
	
	echo $this->Chart->lineChart($counts,$days);
?>