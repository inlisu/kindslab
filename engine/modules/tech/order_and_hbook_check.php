<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$id= $_GET['id'];
	$date= $_GET['date'];
	
	if($date == 'now'){
		$query="SELECT time(start_at), time(finish_at), issue, answer1, answer2, answer3, answer4, schedule.comment, math.action, tasks.name, schedule_daily.name, schedule.plan_id, schedule.auto FROM results LEFT JOIN schedule ON schedule.id = results.schedule_id LEFT JOIN plans ON plans.id = schedule.plan_id LEFT JOIN tasks ON tasks.id = plans.task_id LEFT JOIN math ON math.id = schedule.comment LEFT JOIN schedule_daily ON schedule_daily.id = plans.comment WHERE schedule.postpone=0 AND user_id = $id AND date(finish_at) = date(NOW()) ORDER BY time(finish_at) ASC";
		$result=mysql_query($query) or die ('Query failed :D');
	}
	else{
		$query="SELECT time(start_at), time(finish_at), issue, answer1, answer2, answer3, answer4, schedule.comment, math.action, tasks.name, schedule_daily.name, schedule.plan_id, schedule.auto FROM results LEFT JOIN schedule ON schedule.id = results.schedule_id LEFT JOIN plans ON plans.id = schedule.plan_id LEFT JOIN tasks ON tasks.id = plans.task_id LEFT JOIN math ON math.id = schedule.comment LEFT JOIN schedule_daily ON schedule_daily.id = plans.comment WHERE schedule.postpone=0 AND user_id = $id AND date(finish_at) = date('$date') ORDER BY time(finish_at) ASC";
		$result=mysql_query($query) or die ('Query failed :3');
	}
	echo("<table><tr><td>Начато      </td><td>Закончено   </td><td>Название                                                               </td><td>Номер         </td><td>Ответ 1      </td><td>Ответ 2      </td><td>Ответ 3      </td><td>Ответ 4</td></tr>");
	while(list($time_start,$time_end,$issue,$an1,$an2,$an3,$an4,$schedule_name,$math_name,$task_name,$daily_name,$plan_id,$auto) = mysql_fetch_row($result) ) {
		switch ($plan_id){
			case "0" : {
				echo("<tr><td>$time_start</td><td>$time_end</td><td>$schedule_name</td><td>$issue</td><td>$an1</td><td>$an2</td><td>$an3</td><td>$an4</td></tr>");
				break;
			}
			case "4" : {
				echo("<tr><td>$time_start</td><td>$time_end</td><td>$math_name</td><td>$issue</td><td>$an1</td><td>$an2</td><td>$an3</td><td>$an4</td></tr>");
				break;
			}
			default : {
				if ($auto==0){ 
					echo("<tr><td>$time_start</td><td>$time_end</td><td>$task_name</td><td>$issue</td><td>$an1</td><td>$an2</td><td>$an3</td><td>$an4</td></tr>");
				}
				else{
					echo("<tr><td>$time_start</td><td>$time_end</td><td>$daily_name</td><td>$issue</td><td>$an1</td><td>$an2</td><td>$an3</td><td>$an4</td></tr>");
				}
				break;
			}
		}
	}
	echo("</table>");
?>