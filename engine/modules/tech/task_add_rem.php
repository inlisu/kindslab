<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$task_id= $_GET['task_id'];	
	$state= $_GET['state'];
	if ($state==0){
	$query = "update available_task set date_out=Now() where user_id=(SELECT user_id from dle_users where name='$u_name') and action_id=$task_id and date_out='0000-00-00 00:00:00'";
	$result2 = mysql_query($query) or die("Query failed3");echo('Задача исключена');
	}
	else{
	$query = "insert INTO available_task  (user_id,action_id,type_action,date_in) values ((SELECT user_id from dle_users where name='$u_name'),$task_id,1,Now())";
	$result2 = mysql_query($query) or die("Query failed3");echo('Задача добавлена');
	}

	
//	echo('</ul>'); 
?>