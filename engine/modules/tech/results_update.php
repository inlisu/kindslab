<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	$wrong = $_GET["wrong"];
	$right = $_GET["right"];
	if ($right == 'x'){
		$right = 's';
	}
	else {
		$right_ = explode(":",$right);
		while (list($key, $task_name) = each($right_)) {
			$right_query = "UPDATE results SET results.rate = 1 WHERE results.id = $task_name";
			$result1 = mysql_query($right_query) or die("Query failed:3");
		}
	}
	if ($wrong == 'x'){
		$wrong = 's';
	}
	else {
		$wrong_ = explode(":",$wrong);
		while (list($key_1, $task_name_1) = each($wrong_)) {
			$wrong_query = "UPDATE results SET results.rate = 2 WHERE results.id = $task_name_1";
			$result2 = mysql_query($wrong_query) or die("Query failed:D");
		}
	}
	echo('URAAAAAAAAAAA');
?>