<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];

	$query = "select ROUND(((SELECT UNIX_TIMESTAMP(max(time_end)) FROM `log_action` where time_start>CURDATE() and time_end!='0000-00-00 00:00:00' and user_id=$user_id) - (SELECT UNIX_TIMESTAMP(min(time_start)) FROM `log_action` where time_start >CURDATE() and time_end!='0000-00-00 00:00:00' and user_id=$user_id ))/60 - (SELECT sum((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60) FROM `log_action` where time_start>CURDATE() and time_end!='0000-00-00 00:00:00' and user_id=$user_id ) )";    echo("ok");
	$result2 = mysql_query($query) or die("Query failed:3");
		$p=mysql_fetch_row($result2);
echo("Потеряно $p[0] минут ");

?>