<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$query = "SELECT common_action.id,name,user_id  FROM `common_action` left join (select * from available_task where date_out='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='$u_name')) as df on action_id=common_action.id where active = 1 and creator_id in (0,(SELECT user_id from dle_users where name='$u_name'))";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br>');
	while (list($task_id, $task_name, $on) = mysql_fetch_row($result2) ){
	if (is_null($on)) {
		echo("<input type='checkbox' name='checkbox-1' id='checkbox-$task_id' class='custom'
				  onChange='task_add_rem("
		.'"'
		."$task_id"
		.'","'
		."1"
		.'")'
		."'"
		."'><label for='checkbox-$task_id'>$task_name</label >");
				}
	else {
		echo("
				<input type='checkbox' name='checkbox-1' id='checkbox-$task_id' class='custom' checked
				  onChange='task_add_rem("
		.'"'
		."$task_id"
		.'","'
		."0"
		.'")'
		."'"
		."'><label for='checkbox-$task_id'>$task_name</label > ");
		}
	}

?>