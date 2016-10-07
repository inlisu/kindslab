<?php
	$user_id = $_GET["user_id"];
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$query = "SELECT name FROM log_action LEFT JOIN common_action ON log_action.task_id = common_action.id WHERE user_id = ". $user_id ." AND time_end = 0";
	$result = mysql_query($query) or die("Query failed");
	$task = mysql_result($result, 0);
	echo $task;
?>