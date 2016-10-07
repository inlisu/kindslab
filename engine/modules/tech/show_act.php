<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
		$user_id= $_GET['user_id'];

	$query = "SELECT  dddd, count(dddd)as hm,sum(time) as time from (SELECT activity_type,'Развлечение' as dddd, floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60) as time FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=$user_id and time_start>CURDATE() and time_end != '0000-00-00 00:00:00'  and activity_type & 1>0 union all
SELECT activity_type,'Развитие'  as dddd, floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60) as time FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=$user_id and time_start>CURDATE() and time_end != '0000-00-00 00:00:00'  and activity_type & 2>0 union all
SELECT activity_type,'Общение'  as dddd, floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60) as time FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=$user_id and time_start>CURDATE() and time_end != '0000-00-00 00:00:00'  and activity_type & 4>0 union all
SELECT activity_type,'Творчество'  as dddd, floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60) as time FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=$user_id and time_start>CURDATE() and time_end != '0000-00-00 00:00:00'  and activity_type & 8>0 union all
SELECT activity_type,'Быт'  as dddd, floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60) as time FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=$user_id and time_start>CURDATE() and time_end != '0000-00-00 00:00:00'  and activity_type & 16>0 union all
SELECT activity_type,'Здоровье'  as dddd, floor((UNIX_TIMESTAMP(time_end)- UNIX_TIMESTAMP(time_start))/60) as time FROM `log_action`left join common_action on common_action.id=log_action.task_id where user_id=$user_id and time_start>CURDATE() and time_end != '0000-00-00 00:00:00'  and activity_type & 32>0) as ddd group by dddd ORDER BY time DESC";
	$result2 = mysql_query($query) or die("Query failed3");
	echo('<table>');
	while (list($act_name, $hm, $spend) = mysql_fetch_row($result2) ){
		echo("<tr><td><li><a  class='do_task ui-btn ' onclick='kid10_click("
		.'"'
		."$user_id"
		.'")'
		."'"
		."'>$act_name</a></li>
		</td><td><li><a  class='do_task ui-btn ' onclick='kid11_click("
		.'"'
		."$user_id"
		.'")'
		."'"
		."'>$hm</a></li>
		
		</td><td><li><a  class='do_task ui-btn ' onclick='kid1_click("
		.'"'
		."$user_id"
		.'")'
		."'"
		."'>$spend</a></li>
		
		</td></tr>");
	}
	echo ("</table>");
?>