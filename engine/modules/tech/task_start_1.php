<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_POST['user_id'];
	$task_id= $_POST['task_id'];
	$time= $_POST['time'];
	$sched_id= $_POST['sched_id'];
	$assignment= $_POST['assignment'];
			$query = "INSERT INTO log_action (assignment,duration, time_start, task_id, user_id, sched_id) VALUES ('$assignment', '$time', Now(),$task_id, $user_id, $sched_id)";
			$result = mysql_query($query) or die("Query failed:345");
			$query = "SELECT max(id) FROM log_action";
			$result2 = mysql_query($query) or die("Query failed:ddd");
			$p=mysql_fetch_row($result2);
			$last_id = $p[0];
			echo ("$last_id"); 
?>