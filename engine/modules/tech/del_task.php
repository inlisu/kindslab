<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$task_id= $_GET['task_id'];	
	$query = "update  common_action set active=0 where  id=$task_id";
	$result2 = mysql_query($query) or die("$query Query failed3");
	echo ("Удалили");
?>