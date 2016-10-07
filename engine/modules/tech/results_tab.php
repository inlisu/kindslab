<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$u_id= $_GET['user_id'];
	
	$query = "SELECT plans.id, tasks.name, minute(recommended_time), hour(recommended_time) FROM plans LEFT JOIN tasks ON tasks.id = plans.task_id LEFT JOIN handbooks ON handbooks.id = tasks.subcase_id WHERE plans.complete = 0 AND auto=0 AND plans.performer_id = $u_id";
	$result = mysql_query($query) or die("Query failed3");
	
	echo ('<tr><td>Предмет  </td><td>Завершить   </td><td>Прогресс   </td><td>За 1 день  </td><td>За 5 дней  </td><td>За 10 дней  </td><td>За 30 дней  </td><td>За 50 дней  </td><td>Рекомендовано (в день)</td><td>   Коэффициент</td></tr>');
	
	while (list($plan_id, $fullname, $recommended_minute, $recommended_hour) = mysql_fetch_row($result) ) {
		$query2 = "SELECT exercises, TO_DAYS( dead_line ) - TO_DAYS(NOW()), planned_amount FROM plans LEFT JOIN tasks ON tasks.id = plans.task_id LEFT JOIN handbooks ON handbooks.id = tasks.subcase_id WHERE plans.id = $plan_id";
		$result2 = mysql_query($query2) or die("Query failed :3");
		while (list($general_handbook, $days_left, $general_amount) = mysql_fetch_row($result2) ) {
			$query3 = "SELECT COUNT(*) FROM (SELECT results.id FROM plans LEFT JOIN schedule ON schedule.plan_id = plans.id LEFT JOIN results ON results.schedule_id = schedule.id WHERE plans.id = $plan_id  AND results.user_id = $u_id GROUP BY results.issue ORDER BY `results`.`issue`  DESC) AS amount";
			$result3 = mysql_query($query3) or die("Query failed :D");
			if ($general_amount == '0') {
				$general_amount = $general_handbook;
			}
			$done_amount = mysql_result($result3,0);
			$recommended = ceil((intval($general_amount) - intval($done_amount))/intval($days_left));
			$percent = ceil(intval($done_amount)/intval($general_amount)*100);
			
			$query_1_day = "SELECT COUNT(*) FROM (SELECT results.id FROM plans LEFT JOIN schedule ON schedule.plan_id = plans.id LEFT JOIN results ON results.schedule_id = schedule.id WHERE plans.id = $plan_id AND results.user_id = $u_id AND date(results.finish_at) > date(NOW() - INTERVAL 1 DAY) GROUP BY results.issue ORDER BY `results`.`issue`  DESC) AS amount";
			$result_1_day = mysql_query($query_1_day) or die("Query failed :D");
			$done_1_day = mysql_result($result_1_day,0);
			$done_1_day_percent = ceil(intval($done_1_day)/$recommended*100);
			
			$query_5_day = "SELECT COUNT(*) FROM (SELECT results.id FROM plans LEFT JOIN schedule ON schedule.plan_id = plans.id LEFT JOIN results ON results.schedule_id = schedule.id WHERE plans.id = $plan_id AND results.user_id = $u_id AND date(results.finish_at) > date(NOW() - INTERVAL 5 DAY) GROUP BY results.issue ORDER BY `results`.`issue`  DESC) AS amount";
			$result_5_day = mysql_query($query_5_day) or die("Query failed :D");
			$done_5_day = mysql_result($result_5_day,0);
			$done_5_day_percent = ceil(intval($done_5_day)/($recommended*5)*100);
			
			$query_10_day = "SELECT COUNT(*) FROM (SELECT results.id FROM plans LEFT JOIN schedule ON schedule.plan_id = plans.id LEFT JOIN results ON results.schedule_id = schedule.id WHERE plans.id = $plan_id AND results.user_id = $u_id AND date(results.finish_at) > date(NOW() - INTERVAL 10 DAY) GROUP BY results.issue ORDER BY `results`.`issue`  DESC) AS amount";
			$result_10_day = mysql_query($query_10_day) or die("Query failed :D");
			$done_10_day = mysql_result($result_10_day,0);
			$done_10_day_percent = ceil(intval($done_10_day)/($recommended*10)*100);
			
			$query_30_day = "SELECT COUNT(*) FROM (SELECT results.id FROM plans LEFT JOIN schedule ON schedule.plan_id = plans.id LEFT JOIN results ON results.schedule_id = schedule.id WHERE plans.id = $plan_id AND results.user_id = $u_id AND date(results.finish_at) > date(NOW() - INTERVAL 30 DAY) GROUP BY results.issue ORDER BY `results`.`issue`  DESC) AS amount";
			$result_30_day = mysql_query($query_30_day) or die("Query failed :D");
			$done_30_day = mysql_result($result_30_day,0);
			$done_30_day_percent = ceil(intval($done_30_day)/($recommended*30)*100);
			
			$query_50_day = "SELECT COUNT(*) FROM (SELECT results.id FROM plans LEFT JOIN schedule ON schedule.plan_id = plans.id LEFT JOIN results ON results.schedule_id = schedule.id WHERE plans.id = $plan_id AND results.user_id = $u_id AND date(results.finish_at) > date(NOW() - INTERVAL 50 DAY) GROUP BY results.issue ORDER BY `results`.`issue`  DESC) AS amount";
			$result_50_day = mysql_query($query_50_day) or die("Query failed :D");
			$done_50_day = mysql_result($result_50_day,0);
			$done_50_day_percent = ceil(intval($done_50_day)/($recommended*50)*100);
			$str="<tr><td><span>$fullname          </span></td><td>      <input type=checkbox hidden class=tb3_checkbox value = $plan_id name=tb3_checkbox_name></td><td><span>   $percent %</span></td><td>$done_1_day($done_1_day_percent %)</td><td>$done_5_day($done_5_day_percent %)</td><td>$done_10_day($done_10_day_percent %)</td><td>$done_30_day($done_30_day_percent %)</td><td>$done_50_day($done_50_day_percent %)</td><td>             $recommended</td>";
			echo $str;
		}
		$query_rec = "SELECT day(finish_at) - day(start_at), hour(finish_at) - hour(start_at), minute(finish_at) - minute(start_at) FROM plans LEFT JOIN schedule ON schedule.plan_id = plans.id LEFT JOIN results ON results.schedule_id = schedule.id WHERE results.finish_at != 0 AND results.start_at != 0 AND plans.id = $plan_id AND date(finish_at) = date(NOW()) GROUP BY results.schedule_id ORDER BY `results`.`start_at` DESC";
		$result_rec = mysql_query($query_rec) or die ('Query failed O_o');
		$recommended_minute = $recommended_minute + ($recommended_hour*60);
		
		$real_day = mysql_result($result_rec, 0, 0);
		$real_hour = mysql_result($result_rec, 0, 1);
		$real_minute = mysql_result($result_rec, 0, 2);
		
		if($real_hour<0){
			$real_day=$real_day-1;
			$real_hour=$real_hour+24;
		}
		if($real_minute<0){
			$real_hour=$real_hour-1;
			$real_minute=$real_minute+60;
		}
		
		$real_hour = $real_hour + ($real_day*24);
		$real_minute = $real_minute + ($real_hour*60);
		
		$factor = $recommended_minute/$real_minute;
		$percent_factor = ceil(intval($recommended_minute)/intval($real_minute)*100);
		$last_factor = '';
		$percent_factor = $percent_factor - 100;
		if($percent_factor < 100){
			$last_factor = "$percent_factor" . '%';
		}
		else{
			$last_factor = '+' . "$percent_factor" . '%';
		}
		echo("<td>      $last_factor</td></tr>");
	}
	$query5 = "SELECT plans.id, schedule_daily.name FROM plans LEFT JOIN schedule_daily ON schedule_daily.id = plans.comment WHERE plans.complete = 0 AND auto=1 AND plans.performer_id = $u_id";
	$result5 = mysql_query($query5) or die("Query failed3");
	while (list($plan_id1, $fullname1) = mysql_fetch_row($result5) ) {
		echo("<tr><td><span>$fullname1    </span></td><td>      <input type=checkbox hidden class=tb3_checkbox value = $plan_id1 name=tb3_checkbox_name></td></tr>");
	}
?>