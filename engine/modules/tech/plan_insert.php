<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	$submitter_id = $_GET['usr_id'];
	$task_id = $_GET['task_id'];
	$per_day = $_GET['per_day'];
	$performer_id = $_GET['performer_id'];
	$dead_line = $_GET['dead_line'];
	$plan = $_GET['planned'];
	$query = "INSERT INTO plans (task_id, per_day, performer_id, submitter_id, date_in, dead_line, planned_amount) VALUES($task_id, $per_day, $performer_id, $submitter_id, date(NOW()), date('$dead_line'), '$plan')";
	$result = mysql_query($query) or die($query);
	echo('HAHAHAHAH');
?>