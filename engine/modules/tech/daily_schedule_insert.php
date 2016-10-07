<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$name = $_GET['name'];
	$times = $_GET['times'];
	$recommended_time = $_GET['rec_time'];

	$query = "INSERT INTO schedule_daily (name, times, recommended_time) VALUES ('$name', '$times', '$recommended_time')";
	$result=mysql_query($query) or die ('Query failed :3');
?>