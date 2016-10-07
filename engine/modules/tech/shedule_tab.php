<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$act= $_GET['act'];
	$sched_br= $_GET['sched_br'];
	$add_str="";
	if($sched_br==1) $add_str=" and compensate=1";
//	echo('<ul data-role="listview" data-inset="true" data-theme="a">');
	$query = "select id, name, logic_id from common_action where id in (SELECT action_id FROM `available_task` LEFT JOIN  dle_users ON dle_users.user_id = available_task.user_id where dle_users.name='$u_name' AND date_out='0000-00-00') and active=1 and activity_type&$act<>0" . $add_str;
//	echo($query);
	$result2 = mysql_query($query) or die("Query failed3");
	echo('<br><table>');
	while (list($task_id, $task_name,$logic_id) = mysql_fetch_row($result2) ){
		echo("<tr><td><li><a  class='do_task ui-btn ui-btn-icon-right ui-icon-carat-r' onclick='start_task(".'"'."$task_id".'","'."$task_name".'","'."$logic_id".'")'."'"."'>$task_name</a></td><td>
		<a  class='do_task ui-btn  '><span task_id=$task_id class='trash4 ui-icon ui-icon-trash '></span></a></li></td></tr>");
	}
	echo ("</table>");
?>