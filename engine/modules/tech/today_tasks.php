<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$query = "SELECT duration, DATE_FORMAT(time_start,'%H:%i'),name, floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60)as ee,result,assignment, log_action.id FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=(SELECT user_id from dle_users where name='$u_name') and CURDATE()<time_start and time_end != '0000-00-00 00:00:00' ORDER BY DATE_FORMAT(time_start,'%H:%i') ASC ";
	$result2 = mysql_query($query) or die("$query"); echo ("<br><table>");
while (list($duration, $start, $task_name, $spend,$result,$assignment,$log_id) = mysql_fetch_row($result2) ){
		echo("<tr style='background-color: RGB(249, 201, 16)'><td><li><a style='background-color: RGB(249, 201, 16)' class='do_task ui-btn ' onclick='ex_log("
		.'"'
		."$log_id"
		.'","'
		."$u_name"
		.'")'
		."'"
		."'>$task_name</a></li></td><td><li><a  class='do_task ui-btn' onclick='kid1_click("
		.'"'
		."$task_name"
		.'","'
		."$u_name"
		.'")'
		."'"
		."'>$start</a></li></td><td><li><a  class='do_task ui-btn' onclick='kid1_click("
		.'"'
		."$task_name"
		.'","'
		."$u_name"
		.'")'
		."'"
		."'>$spend</a></li></td></tr>"
		."<tr><td colspan='3'><li><a  class='do_task ui-btn' onclick=empty($u_name)>$assignment</a></li></td></tr>"
		."<tr><td colspan='3'><li><a  class='do_task ui-btn' onclick=empty($u_name)>$result</a></li></td></tr>");
	}
	echo ('</table>');
?>