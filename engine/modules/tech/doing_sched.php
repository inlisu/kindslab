<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];
	$sched_id= $_GET['sched_id'];	
	$query = "SELECT common_action.id,sched_id, DATE_FORMAT(time_start,'%H:%i')as time__start,DATE_FORMAT(time_end,'%H:%i')as time__end, common_action.name, floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60)as ee, review, time_start FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=$user_id and CURDATE()<time_start and sched_id!=0  ORDER BY DATE_FORMAT(time_start,'%H:%i') ASC";//and common_action.id in (SELECT task_id FROM `schedule` where user_id=$user_id group by task_id )
	$result2 = mysql_query($query) or die("$query Query failed3");		
	while (list($task_id, $id,$time_start, $time_end, $name, $delta,$result, $time_start) = mysql_fetch_row($result2) ){
		if ($delta>=0) echo("$id,$result,$time_start,$delta---");
		else echo("-$id,$result,$time_start,$delta---");
		}
?>