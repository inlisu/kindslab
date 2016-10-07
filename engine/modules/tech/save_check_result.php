<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$sched_id= $_GET['sched_id'];
	$result= $_GET['result'];
	
	$query = "update log_action set review=$result where sched_id=$sched_id and CURDATE()<time_start";
	$result2 = mysql_query($query) or die("Query failed33");
echo('Ok');
?>