<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$schedule_id= $_GET['schedule_id'];
	
	$query = "SELECT month(NOW()) - month(start_at), day(NOW()) - day(start_at), hour(NOW()) - hour(start_at), minute(NOW()) - minute(start_at), hour(recommended_time), minute(recommended_time) FROM results LEFT JOIN schedule ON schedule.id = $schedule_id WHERE schedule_id = $schedule_id GROUP BY schedule_id";
	$result = mysql_query($query) or die("Query failed3");
	
	$month=mysql_result($result, 0, 0)*1;
	$day=mysql_result($result, 0, 1)*1;
	$hour=mysql_result($result, 0, 2)*1;
	$minute=mysql_result($result, 0, 3)*1;
	$rec_hour=mysql_result($result, 0, 4)*1;
	$rec_minute=mysql_result($result, 0, 5)*1;
	
	$day = $day + ($month*31);
	$hour = $hour + ($day*24);
	
	$check_minute_1 = $minute + ($hour*60);
	$check_minute_2 = $rec_minute + ($rec_hour*60);
	
	if($check_minute_1>$check_minute_2){
		echo('late');
	}
	else{
		echo($check_minute_2 - $check_minute_1);
	}
?>