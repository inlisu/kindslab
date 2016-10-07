<title>Jack</title>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$u_id = $_GET['u_id'];
		
	$query_check = "SELECT state FROM management WHERE id = 1";
	$result_check = mysql_query($query_check) or die ('Query Failed :D');
	$condition = mysql_result($result_check, 0, 0);
	
	$highest_time = 0;
	$highest_plan_id = 0;
	$counter = 0;
	$local_time = 0;
	
	if($condition == '0'){
		$subquery = "SELECT hour(last_update), minute(last_update) FROM schedule WHERE auto = 1 AND performer_id = $u_id AND date(last_update) = date(NOW()) ORDER BY `last_update` DESC";
		$subresult = mysql_query($subquery) or die ('Query Failed :D');
		$last_hour_done = mysql_result($subresult, 0, 0);
		$last_minute_done = mysql_result($subresult, 0, 1);
		$last_time_done = $last_hour_done*60 + $last_minute_done;
		
		$query = "SELECT name, times, plans.id, hour(NOW()), minute(NOW()), schedule_daily.recommended_time FROM plans LEFT JOIN schedule_daily ON schedule_daily.id=plans.comment WHERE performer_id=$u_id and auto=1 AND complete = 0";
		$result=mysql_query($query) or die ('Query failed :3');
		while (list($name, $times, $plan_id, $hour_now, $minute_now, $recommended_time) = mysql_fetch_row($result) ) {
			$now = $hour_now*60 + $minute_now;
			$times_ = explode(",",$times);
			while (list($key, $time) = each($times_)) {
				$time_ = explode(":",$time);
				while (list($key, $time__) = each($time_)) {
					if($counter == 0){
						$local_time = $local_time + $time__*60;
					}
					else{
						$local_time = $local_time + $time__;
					}
					$counter = $counter + 1;
				}
				if($local_time > $highest_time && $local_time < $now){
					$highest_time = $local_time;
					$highest_plan_id = $plan_id;
					$highest_name = $name;
					$highest_recommended_time = $recommended_time;
				}
				$local_time = 0;
				$counter = 0;
			}
		}
		$subquery2 = "SELECT * FROM schedule WHERE plan_id = $highest_plan_id AND time_end = 0 AND performer_id = $u_id";
		$subresult2 = mysql_query($subquery2) or die ($subquery2);
		if($highest_time > $last_time_done & mysql_num_rows($subresult2) == 0){
			$query3="INSERT INTO schedule (auto, for_date, plan_id, submitter_id, performer_id, comment, recommended_time) VALUES ('1', date(NOW()), '$highest_plan_id', '0', '$u_id', '$highest_name', '$highest_recommended_time')";
			$result3=mysql_query($query3) or die ('Query failed ^_^');
		}
	}
?>