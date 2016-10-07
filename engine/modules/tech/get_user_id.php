<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];

	$query = "select user_id from dle_users   where name='$u_name'";    
	$result2 = mysql_query($query) or die("Query failed:3");
	$p=mysql_fetch_row($result2);
	echo($p[0]);

?>