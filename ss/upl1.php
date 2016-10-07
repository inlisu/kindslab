<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$name= $_GET['name'];
	$pass= $_GET['pass'];
			$query = "SELECT dalays FROM common_action left join log_action on common_action.id=task_id left join dle_users on dle_users.user_id =common_action.creator_id where dle_users.name='$name' and time_end='0000-00-00 00:00:00'";
			$result2 = mysql_query($query) or die("$query Query failed:ddd");
			$p=mysql_fetch_row($result2);
			if($p[0]) echo ($p[0]);
			else echo ("40:40");
?>