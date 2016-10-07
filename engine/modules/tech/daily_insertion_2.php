<title>Jack</title>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$u_id = $_GET['u_id'];
		
	$query_check = "SELECT state FROM management WHERE id = 1";
	$result_check = mysql_query($query_check) or die ('Query Failed :D');
	$condition = mysql_result($result_check, 0, 0);
	
	if($condition == '0'){
		$query = "SELECT name, times, plans.id, time(NOW()), schedule_daily.recommended_time FROM plans LEFT JOIN schedule_daily ON schedule_daily.id=plans.comment WHERE performer_id=$u_id and auto=1 AND complete = 0";
		$result=mysql_query($query) or die ('Query failed :3');
		while (list($name, $times, $plan_id, $now, $recommended_time) = mysql_fetch_row($result) ) {
			$local_array_of_times=array();
			//echo($name . '  ' . $times . '  ' . $plan_id . '  ' . $now . '  ' . $recommended_time);
			//echo('<br>');
			$times_ = explode(",",$times);
			while (list($key, $time) = each($times_)) {
				//echo($time);
				//echo('<br>');
				array_push($local_array_of_times, $time);
				
			}
			$query2="SELECT COUNT(*) FROM schedule WHERE auto=1 AND plan_id=$plan_id AND for_date = date(NOW())";
			//echo($query2);
			//echo('<br>');
			$result2=mysql_query($query2) or die ('Query Failed :D');
			$how_much_done_today=mysql_result($result2, 0, 0);
			$now = substr($now, 0, strlen($now)-3);
			//echo($how_much_done_today);
			//echo('<br>');
			//echo($now);
			//echo('<br>');
			//echo($local_array_of_times[$how_much_done_today]);
			//echo('<br>');
			if($how_much_done_today == 0){
				//echo('how_much_done_today == 0');
				//echo('<br>');
				if($local_array_of_times[$how_much_done_today] < $now){
					//echo('больше, ага');
					//echo('<br>');
					$query3="INSERT INTO schedule (auto, for_date, plan_id, submitter_id, performer_id, comment, recommended_time) VALUES ('1', date(NOW()), '$plan_id', '0', '$u_id', '$name', '$recommended_time')";
					$result3=mysql_query($query3) or die ('Query failed ^_^');
				}
			}
			else{
				//echo('ББольше, ага');
				//echo('<br>');
				$size_of_array=count($local_array_of_times);
				//echo($size_of_array);
				//echo('<br>');
				if($how_much_done_today < $size_of_array){
					if($local_array_of_times[$how_much_done_today] < $now){
						$query4="INSERT INTO schedule (auto, for_date, plan_id, submitter_id, performer_id, comment) VALUES ('1', date(NOW()), '$plan_id', '0', '$u_id', '$name')";
						$result4=mysql_query($query4) or die ('Query failed :O');
					}
				}
			}
			//echo('<br>');
			//echo('<br>');
			//echo('<br>');
		}
	}
?>