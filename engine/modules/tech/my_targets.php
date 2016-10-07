<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];
	$query = "SELECT id, name   FROM projects where date_finished='0000-00-00 00:00:00' and user_id=$user_id";
	$result2 = mysql_query($query) or die("Query failed3");
	echo("<option id=0></option>");
	while (list($id, $description) = mysql_fetch_row($result2) ){
	echo("<option id=targ$id> $description</option>");
	}