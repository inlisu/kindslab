<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$schedule_id = $_GET['sch'];
	$status = $_GET['status'];
	
	$query = "UPDATE schedule SET request = '$status' WHERE id = '$schedule_id'";
	$result = mysql_query ($query) or die ($query);
?>