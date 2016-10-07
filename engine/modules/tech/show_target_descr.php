<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$id= $_GET['id'];
	$query = "SELECT description   FROM `projects` where id=$id";	
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table>');
	$p1=mysql_fetch_row($result2);
    $description = $p1[0];
	echo ($description);
?>