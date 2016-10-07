<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_POST['u_name'];
	$task_id= $_POST['task_id'];
	$result_= $_POST['result'];
	$qw= $_POST['qw'];
	$all= $_POST['all'];
	$con= $_POST['con'];
	$mood= $_POST['mood'];
	$query_question1 = "SELECT task_id, common_action.name, logic_id FROM log_action left join dle_users on dle_users.user_id = log_action.user_id left join common_action on common_action.id = task_id  where dle_users.name='$u_name' and log_action.time_end='0000-00-00 00:00:00'";
	$result = mysql_query($query_question1) or die("Query failed:D");
	$p=mysql_fetch_row($result);
    $id_task = $p[0];
	
	$fffd="";
		if ($all==0) {			
			$fffd=",sched_id=0";	
		}
	if ($id_task == $task_id){
		$query = "update `log_action` left join dle_users on `log_action`.user_id = dle_users.user_id set `time_end`= Now(),result='$result_',qw=$qw,all_=$all,con=$con,mood=$mood $fffd  where task_id=$task_id and name='$u_name' and time_end='0000-00-00 00:00:00'";
			
		$result = mysql_query($query) or die($query ."Query failed:2");
		echo("Act_close");
		}
	else{
		if (is_null($id_task)){
			echo("No_open_act");
			}
		else{
			$task_name = $p[1];
			$logic_id = $p[2];
			echo("Another_exist,$task_name,$id_task,$logic_id");
			}
		}
?>