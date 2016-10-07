<?php
	// Надо переделать - гигантская уязвимость!!! как в rating.php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	$task_date= $_GET['task_date'];
	$task_txt= $_GET['task_txt'];
	$users= $_GET['users'];
	$submiter_id= $_GET['submiter_id'];
	$case_action= $_GET['case_action'];
	$recommended_time = $_GET['recommended_time'];
	$users_ = explode(":",$users);
	switch($case_action){
		case "4" : {
			while (list($key, $user_id) = each($users_)) {
				$sql="INSERT INTO `schedule` (`for_date`, `plan_id`, `comment`, `submitter_id`, `performer_id`, `recommended_time`) VALUES ('$task_date', '$case_action', '$task_txt', '$submiter_id', '$user_id', '00:20')";
				$rrrrr = mysql_query($sql) or die($sql);
				echo "ok!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
			}			
		}
		case "5" : {
			$sql="INSERT INTO `schedule` (`for_date`, `plan_id`, `comment`, `submitter_id`, `performer_id`) VALUES ";
			while (list($key, $user_id) = each($users_)) {
				$sql=$sql . "('" . $task_date . "', '" . $case_action . "', '" . $task_txt . "', " . $submiter_id . ", " . $user_id . "),";
			}
			$sql=substr($sql, 0, strlen($sql)-1); // remove last symbol - ,
			$rrrrr = mysql_query($sql) or die($sql);
			echo "ok!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
		}
		default : {
			$sql="INSERT INTO `schedule` (`for_date`, `comment`, `submitter_id`, `performer_id`, `recommended_time`) VALUES ";
			while (list($key, $user_id) = each($users_)) {
				$sql=$sql . "('" . $task_date . "', '" . $task_txt . "', " . $submiter_id . ", " . $user_id . ", '" . $recommended_time . "'),";
			}
			$sql=substr($sql, 0, strlen($sql)-1); // remove last symbol - ,
			$rrrrr = mysql_query($sql) or die($sql);
			echo "ok!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
		}
	}
	
	
	
	
	
?>