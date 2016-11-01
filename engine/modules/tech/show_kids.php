<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name_p= $_GET['u_name'];
	$query = "SELECT dle_users.user_id, dle_users.name, fg.name, fg.duration, 
                     fg.spend, fg.assignment,dle_users.money, blank.bl 
              FROM `dle_users` 
              left join ( select name, user_id, duration, FLOOR((UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(time_start))/60) as spend, 
                                 assignment 
                         from log_action 
                         left join common_action on common_action.id = task_id 
                         where time_end='0000-00-00 00:00:00') as fg on fg.user_id=dle_users.user_id 
                         left join (
                         			select user_id , FLOOR((UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(time_end)))/60) as bl 
                         			from log_action group by user_id) as blank on blank.user_id=dle_users.user_id 
                         			where dle_users.user_id in (select ch_id from parents 
                         			where p_id = (select user_id from dle_users where name='$u_name_p'))";
	$result2 = mysql_query($query) or die("Query failed33");
echo('<br><table>');
	while (list($user_id, $u_name, $task_name, $duration, $spend,$assignment,$money,$blank) = mysql_fetch_row($result2) ){
		if ($spend=="") $spend=$blank;
		echo("<tr><td><li><a  class='do_task ui-btn' onclick=show_rules_list(1,'$u_name')>$u_name </a></li></td>
		<td><li><a class='do_task ui-btn' onclick=kid_click1($user_id)>$money</a></li></td>
		<td><li><a class='do_task ui-btn' onclick=kid_viol($user_id)>$spend </a></li></td><td><li><a  class='do_task ui-btn' onclick='kid_click("
		.'"'
		."$u_name"
		.'")'
		."'"
		."'>$task_name</a></li></td></tr>"
		."<tr><td colspan='2'><li><a  class='do_task ui-btn' onclick='min_lost($user_id)'>$assignment</a></li></td><td><li><a  class='do_task ui-btn' onclick='show_targets_list($user_id)'>$assignment</a></li></td>
		<td colspan='1'><li><a  class='do_task ui-btn' onclick='show_schedule(0,$user_id)'>$assignment</a></li></td>
		</tr>");
	}
	echo ("</table>");
/*

 SELECT dle_users.user_id, dle_users.name, fg.name, fg.duration, fg.spend, fg.assignment,
        dle_users.money, blank.bl
 FROM `dle_users`
 left join (
             select name, user_id, duration, FLOOR((UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(time_start))/60) as spend, assignment
             from log_action
             left join common_action on common_action.id = task_id
             where time_end='0000-00-00 00:00:00') as fg
  on fg.user_id=dle_users.user_id
  left join (
              select user_id , FLOOR((UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(max(time_end)))/60) as bl
              from log_action group by user_id) as blank
  on blank.user_id=dle_users.user_id
  where dle_users.user_id in (select ch_id from parents where p_id = (select user_id from dle_users where name='$u_name_p')



*/