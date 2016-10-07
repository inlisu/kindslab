<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$query = "SELECT task_id, common_action.name, logic_id FROM log_action left join dle_users on dle_users.user_id = log_action.user_id left join common_action on common_action.id = task_id  where dle_users.name='$u_name' and log_action.time_end='0000-00-00 00:00:00'";
	$result2 = mysql_query($query) or die("Query failed:3");
	$p=mysql_fetch_row($result2);
    echo("$p[0]*$p[1]*$p[2]");
?>