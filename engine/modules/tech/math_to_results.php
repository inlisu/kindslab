<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$time=$_GET["time"] * 1;
	$u_name=$_GET["u_name"];
	$total=$_GET["total"];
	$wrong=$_GET["wrong"];
	$action=$_GET["action"];
	$query = "SELECT user_id, now() FROM dle_users WHERE name='" . $u_name . "'";
	$result2 = mysql_query($query) or die($query);
	$user_id = mysql_result($result2,0,0);
	$result3 = mysql_result($result2,0,1);
	list($date, $now_time) = explode(' ', $result3);
	list($hour, $minute, $second) = explode(':', $now_time);
	$hour = $hour * 1;
	$minute = $minute * 1; 
	$second = $second * 1;
	$total_now = ($hour * 3600) + ($minute * 60) + $second;
	$time_start = $total_now - $time;
	if($time_start>60){
		$second_start = $time_start%60;
		$minute_start = ($time_start - $second_start)/60;
		if($minute_start>60){
			$hour_start = ($minute_start - $minute_start%60)/60;
			$minute_start = $minute_start%60;
		}
		else{
			$hour_start = '00';
		}
	}
	else{
		$minute_start = '00';
		$hour_start = '00';
	}
	if($second_start<10){
		$second_start = '0' . $second_start;
	}
	if($hour_start<10 and $hour_start != '00'){
		$hour_start = '0' . $hour_start;
	}
	if($minute_start<10 and $minute_start != '00'){
		$minute_start = '0' . $minute_start;
	}
	$time_to_database = $date . ' ' . $hour_start . ':' . $minute_start . ':' . $second_start;
	$query1 = "INSERT INTO math_results (user_id, time_start, duration, total, wrong, action) VALUES ('$user_id', now(), '$time', '$total', '$wrong', '$action')";
	$result4 = mysql_query($query1) or die("Query failed3");
/* 	$query1 = "update log_action set time_end=now(), note='$total-$wrong-$action' where user_id=$user_id and time_end='0000-00-00 00:00:00' ";
	$result4 = mysql_query($query1) or die("Query failed5"); */
		if($action==5 || $action==18){
		if ($wrong==0) $bonus=30;
		else $bonus=15;
		$query1 = "update dle_users set money=money+$bonus where user_id=$user_id";
	$result4 = mysql_query($query1) or die("Query failed3");
	}
?>