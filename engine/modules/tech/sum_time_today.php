<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
		$u_name= $_GET['u_name'];
		$shift= $_GET['shift'];
		$shift1=$shift-1;
	$query = "SELECT  name, count(name), sum(floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60))as ee FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=(SELECT user_id from dle_users where name='$u_name') and time_start>DATE_SUB(CURDATE(),interval $shift day) and time_start<DATE_SUB(CURDATE(),interval $shift1 day) and time_end != '0000-00-00 00:00:00' group by name ORDER BY ee DESC ";
	$result2 = mysql_query($query) or die("Query failed3");
	echo('<table>');
	while (list($task_name, $c_name, $spend) = mysql_fetch_row($result2) ){
		echo("<tr><td><li><a  class='do_task ui-btn ' onclick='kid1_click("
		.'"'
		."$u_name"
		.'")'
		."'"
		."'>$task_name</a></li>
		</td><td><li><a  class='do_task ui-btn ' onclick='kid1_click("
		.'"'
		."$u_name"
		.'")'
		."'"
		."'>$spend</a></li>
		
		</td><td><li><a  class='do_task ui-btn ' onclick='kid1_click("
		.'"'
		."$u_name"
		.'")'
		."'"
		."'>$c_name</a></li>
		
		</td></tr>");
	}
	echo ("</table>");
?>