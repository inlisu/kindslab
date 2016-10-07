<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_POST['user_id'];
	$task_id= $_POST['task_id'];
	$result_= $_POST['result'];

		
	$query = "update `log_action`  set `time_end`= Now(),result=CONCAT('$result_',' ',FLOOR(UNIX_TIMESTAMP(Now())-UNIX_TIMESTAMP(time_start)))  where task_id=$task_id and user_id=$user_id and time_end='0000-00-00 00:00:00'";
	$result = mysql_query($query) or die("Query failed:D");
	
	
	$query_question1 = "SELECT FLOOR((UNIX_TIMESTAMP(time_end)-UNIX_TIMESTAMP(time_start))) as spend from log_action where id=(select max(id) from log_action where task_id=4 and user_id='$user_id' and time_end!='0000-00-00 00:00:00')";
	$result = mysql_query($query_question1) or die("Query failed:D");
	$p=mysql_fetch_row($result);
	echo $p[0];
	?>