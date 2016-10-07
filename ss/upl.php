<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$name= $_POST['name'];
	$pass= $_POST['pass'];

			$query = "SELECT user_id FROM dle_users where name=$name";
			$result2 = mysql_query($query) or die("Query failed:ddd");
			$p=mysql_fetch_row($result2);
			if($p[0]) echo ("ok");
			else echo ("no");
?>