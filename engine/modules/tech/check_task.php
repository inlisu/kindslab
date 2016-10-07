<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$id='';
	$u_name= $_GET['u_name'];
	$task_id= $_GET['task_id'];
	$query_question1 = "SELECT COUNT(*) FROM violation left join rules on violation.rule_id=rules.id left join dle_users on dle_users.user_id = rules.user_id where dle_users.name=$u_name and date_paid='0000-00-00 00:00:00'";
	$result1 = mysql_query($query_question1) or die("Query failed:D!!");
	$p1=mysql_fetch_row($result1);
    $count_viol = $p1[0];

	$query_question1 = "SELECT count(*) FROM `log_action` left join dle_users on dle_users.user_id = log_action.user_id where dle_users.name=$u_name and time_start>CURDATE() and review=-1"	;
	$result = mysql_query($query_question1) or die("Query failed:D");
	$p=mysql_fetch_row($result);
	$count_red = $p[0]; 
	
	
	
	$query_question1 = "SELECT task_id, common_action.name, logic_id FROM log_action left join dle_users on dle_users.user_id = log_action.user_id left join common_action on common_action.id = task_id  where dle_users.name=$u_name and log_action.time_end='0000-00-00 00:00:00'";
	$result = mysql_query($query_question1) or die("Query failed:D");
	$p=mysql_fetch_row($result);
    $id_task = $p[0];
	$logic_id = $p[2];
	$task_name = $p[1];
		if (($count_viol >0 or $count_red>0)&& $task_id!=155 && $task_id!=11+2+4  ){
		exit("Violation,$task_name,$id_task,$logic_id");
	}
	if ($id_task == $task_id){
		echo("Already_exist,$task_name,$id_task,$logic_id");
	}
	else{
		if (is_null($id_task)){
			echo("New_act_create,$task_name,$id_task,$logic_id");
		}
		else{
			
			echo("Another_exist,$task_name,$id_task,$logic_id");
		}
	}
?>