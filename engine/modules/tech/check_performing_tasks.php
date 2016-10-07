<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$u_id = $_GET['u_id'];
	
	$query = "SELECT results.id, results.user_id, tasks.name, schedule.comment, plan_id, fullname, math.action, test_groups.short_description, schedule.auto, schedule_daily.name, results.start_at, month(NOW()) - month(start_at), day(NOW()) - day(start_at), hour(NOW()) - hour(start_at), minute(NOW()) - minute(start_at) FROM results LEFT JOIN schedule ON schedule.id = results.schedule_id LEFT JOIN plans ON plan_id = plans.id LEFT JOIN tasks ON task_id = tasks.id LEFT JOIN dle_users ON dle_users.user_id = schedule.performer_id LEFT JOIN math ON math.id = schedule.comment LEFT JOIN test_groups ON test_groups.id = schedule.comment LEFT JOIN schedule_daily ON schedule_daily.id=plans.comment WHERE results.finish_at = 0 AND results.start_at != 0 AND family_id = (SELECT family_id FROM dle_users WHERE dle_users.user_id = $u_id)";
	$result = mysql_query($query) or die("Query failed3");
	echo("<tr><td>Имя</td><td>      </td><td>Название задания</td><td>      </td><td>Время начала</td><td>      </td><td>Выполняется</td><td>      </td><td>Последнее завершённое задание</td><td>      </td><td>Завершить</td></tr>");
	while (list($results_id, $results_user_id, $task_name, $comment, $plan_id, $fullname, $math_action, $short_description, $auto, $daily_name, $start_at, $month, $day, $hour, $minute) = mysql_fetch_row($result)){
		$query2 = "SELECT month(NOW()) - month(finish_at), day(NOW()) - day(finish_at), hour(NOW()) - hour(finish_at), minute(NOW()) - minute(finish_at), finish_at, id, last_update FROM results WHERE user_id = $results_user_id ORDER BY `results`.`finish_at` DESC";
		$result3 = mysql_query($query2) or die ('Query failed :O');
		$month1 = mysql_result($result3, 0, 0);
		$day1 = mysql_result($result3, 0, 1);
		$hour1 = mysql_result($result3, 0, 2);
		$minute1 = mysql_result($result3, 0, 3);
		$finish1 = mysql_result($result3, 0, 4);
		$id1 = mysql_result($result3, 0, 5);
		$last1 = mysql_result($result3, 0, 6);
		
		$month=$month*1;
		$day=$day*1;
		$hour=$hour*1;
		$minute=$minute*1;
		
		if($minute<0){
			$hour=$hour-1;
			$minute=$minute+60;
		}
		if($hour<0){
			$day=$day-1;
			$hour=$hour+24;
		}
		if($day<0){
			$month=$month-1;
			$day=$day+31;
		}
		if($minute1<0){
			$hour1=$hour1-1;
			$minute1=$minute1+60;
		}
		if($hour1<0){
			$day1=$day1-1;
			$hour1=$hour1+24;
		}
		if($day1<0){
			$month1=$month1-1;
			$day1=$day1+31;
		}
		$day = $day + ($month*31);
		$hour = $hour + ($day*24);
		$minute = $minute + ($hour * 60);
		
		$day1 = $day1 + ($month1*31);
		$hour1 = $hour1 + ($day1*24);
		$minute1 = $minute1 + ($hour1 * 60);
		
		$time = $minute . ' мин';
		$time1 = $minute1 . ' мин';
		switch ($plan_id){
			case "0" : {
				$str="<tr id='$results_id'><td>$fullname</td><td>      </td><td>$comment</td><td>      </td><td>$start_at</td><td>      </td><td>$time</td><td>      </td><td>$time1</td><td>      </td><td><button class='end_result_button' value='$results_id'>Завершить</button></td></tr>";
				echo $str;
				break;
			}
			case "4" : {
				$str="<tr id='$results_id'><td>$fullname</td><td>      </td><td>$math_action</td><td>      </td><td>$start_at</td><td>      </td><td>$time</td><td>      </td><td>$time1</td><td>      </td><td><button class='end_result_button' value='$results_id'>Завершить</button></td></tr>";
				echo $str;
				break;
			}
			default : {
				if ($auto==0){
					$str="<tr id='$results_id'><td>$fullname</td><td>      </td><td>$task_name</td><td>      </td><td>$start_at</td><td>      </td><td>$time</td><td>      </td><td>$time1</td><td>      </td><td><button class='end_result_button' value='$results_id'>Завершить</button></td></tr>";
					echo $str;
				}
				else{
					$str="<tr id='$results_id'><td>$fullname</td><td>      </td><td>$comment</td><td>      </td><td>$start_at</td><td>      </td><td>$time</td><td>      </td><td>$time1</td><td>      </td><td><button class='end_result_button' value='$results_id'>Завершить</button></td></tr>";
					echo $str;
				}
				break;
			}
		}
	}
?>
<script>
	$(".end_result_button").click(function (){
		var result_id = $(this).attr('value');
		var str = "?result_id="+result_id;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open('GET', 'engine/modules/tech/end_result.php'+str, true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4) {
				if(xmlhttp.status == 200) {
					$("[id="+result_id+"]").fadeOut('slow');
				}
			}
		}
		xmlhttp.send(null);
	});
</script>