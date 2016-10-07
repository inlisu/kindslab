<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$sched_id= $_GET['sched_id'];	
	$query = "update  shed_name_id set date_out=now() where id=$sched_id";
	$result2 = mysql_query($query) or die("$query Query failed3");
	echo ("Удалено");
?>