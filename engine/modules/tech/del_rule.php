<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$rule_id= $_GET['rule_id'];	
	$query = "update  rules set date_end=now() where  id=$rule_id";
	$result2 = mysql_query($query) or die("$query Query failed3");
	echo ("Удалили");
?>