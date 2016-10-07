<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$result_id = $_GET['result_id'];
	
	$query="DELETE FROM results WHERE results.id = $result_id";
	$result = mysql_query($query) or die ('Query Failed :D');
?>