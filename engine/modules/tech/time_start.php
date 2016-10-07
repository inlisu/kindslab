<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$sch_id=$_GET["sch_id"];
	
	$query3 = "SELECT start_at FROM results WHERE schedule_id=$sch_id";
	$result3 = mysql_query($query3) or die("Query failed ^_^");
	$start_at = mysql_result($result3, 0, 0);
	if(mysql_num_rows($result3) == 0){
		$query = "SELECT performer_id FROM schedule WHERE id=$sch_id";
		$result = mysql_query($query) or die("Query failed:3");
		$user_id = mysql_result($result, 0, 0);
		
		$query2 = "INSERT INTO results (user_id, schedule_id, start_at) VALUES ('$user_id', '$sch_id', NOW())";
		$result2 = mysql_query($query2) or die("Query failed:D");
	}
	//else{
	//	if
	//	$query4 = "UPDATE results SET start_at = NOW() WHERE schedule_id=$sch_id";
	//	$result4 = mysql_query($query4) or die("Query failed :O");
	//}
?>