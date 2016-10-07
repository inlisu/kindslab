<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$date = $_GET['date'];
	$schedule_id = $_GET['sch'];
	$user_group = $_GET['user_group'];
	
	$sql = "UPDATE schedule SET postpone = date('$date') WHERE id = '$schedule_id'";
	if($user_group == 6){
		$query_2 = "UPDATE schedule SET postpone = date('$date'), request = '2' WHERE id = '$schedule_id'";
		$result_2 = mysql_query($query_2) or die ($query_2);
		echo($query_2);
	}
	else{
		$result = mysql_query($sql) or die("Query failed:3");
	}
?>