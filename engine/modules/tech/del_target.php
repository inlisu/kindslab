<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$target_id= $_GET['target_id'];	
	$query = "update  projects set date_finished=now() where  id=$target_id";
	$result2 = mysql_query($query) or die("$query Query failed3");
	echo ("Удалили");
?>