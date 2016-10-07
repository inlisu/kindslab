<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$id= $_GET['id'];
	$u_id= $_GET['u_id'];
	$percent = $_GET['percent']*1;
	
	
	$query = "SELECT * FROM plans WHERE performer_id = '$u_id' AND auto = 2 AND comment = '$id' AND complete = 0";
	echo($query . '  ');
	$result = mysql_query($query) or die ($query);
	$num_rows = mysql_num_rows($result);
	//echo($num_rows . '  ');
	
	if($num_rows == 0){
		$query1 = "INSERT INTO plans (auto, performer_id, submitter_id, comment, date_in) VALUES ('2', '$u_id', '$u_id', '$id', date(NOW()))";
		$result1 = mysql_query($query1) or die ($query1);
	}
	else{
		if($percent == 75){
			$query2 = "UPDATE plans SET complete = NOW(), task_id = 100 WHERE performer_id = '$u_id' AND comment = '$id'";
			$result2 = mysql_query($query2) or die ('Query Failed :O');
		}
		else{
			$percent = $percent + 25;
			$query3 = "UPDATE plans SET task_id = '$percent' WHERE performer_id = '$u_id' AND comment = '$id'";
		//	echo($query3 . '<br>');
			$result3 = mysql_query($query3) or die ('Query Failed :O');
		}
	}
?>