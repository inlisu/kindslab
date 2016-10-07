<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	$daily_id = $_GET['daily_id'];
	$performer_id = $_GET['performer_id'];
	$user_id = $_GET['user_id'];
	$query = "INSERT INTO plans (auto, performer_id, submitter_id, comment, date_in) VALUES('1', '$performer_id', '$user_id','$daily_id', date(NOW()))";
	$result = mysql_query($query) or die('Query failed :3');
	echo('HAHAHAHAH');
?>