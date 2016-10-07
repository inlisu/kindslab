<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$task_name= $_GET['task_name'];	
	$activity_type= $_GET['activity_type'];	
	$id= $_GET['id'];	

	$query = "insert INTO common_action  ( name, logic_id, date_creation, creator_id, active, activity_type, target_id) values ('$task_name',1,now(),(SELECT user_id from dle_users where name='$u_name'),1,$activity_type, $id)";
	$result2 = mysql_query($query) or die("$query Query failed3");
	echo('Задача добавлена');

//	echo('</ul>'); 