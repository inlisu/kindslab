<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$user_id=$_GET["user_id"];
	$schedule_id_get=$_GET["schedule_id"];
	
	$query = "SELECT schedule_id FROM results WHERE results.finish_at = 0 AND date(results.start_at) != 0 AND user_id = '$user_id' GROUP BY results.schedule_id";
	$result = mysql_query($query) or die ('Query failed :3');
	if(mysql_num_rows($result) == 0 || $schedule_id_get == mysql_result($result, 0, 0)){
		echo('Access allowed');
	}
	else{
		$schedule_id = mysql_result($result, 0, 0);
		echo($schedule_id);
	}
?>