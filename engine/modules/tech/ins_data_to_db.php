<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$log_id= $_GET['log_id'];
	$ex= $_GET['ex'];
	$query1 = "insert INTO ex_log (log_id,ex, date) values ($log_id,$ex, now())";
	$result2 = mysql_query($query1) or die("Query failed6");
	echo("Обработано и записано");
?>