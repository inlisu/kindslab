<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	$u_id = $_GET["u_id"];
	$name = $_GET['name'];
	$date = $_GET['date'];
	if ( $date == 'xxx' ) {
		$query_question = "insert into schedule  (plan_id, submitter_id,  performer_id, how_much, for_date, time_start) SELECT id, submitter_id, performer_id, per_day, for_date1, NOW() FROM `plans`left join (select date(NOW()) as for_date1) as sdf on 1=1 where complete=0 and performer_id =$u_id and plans.id = $name and id not in (SELECT plan_id FROM `schedule` where for_date=date('NOW()') group by plan_id)";
		$result2 = mysql_query($query_question) or die("Query failed:3");
		echo($query_question);
	}
	else {
		$query_question = "insert into schedule  (plan_id, submitter_id,  performer_id, how_much, for_date, time_start) SELECT id, submitter_id, performer_id, per_day, for_date1, NOW() FROM `plans`left join (select date('$date') as for_date1) as sdf on 1=1 where complete=0 and performer_id =$u_id and plans.id = $name and id not in (SELECT plan_id FROM `schedule` where for_date=date('NOW()') group by plan_id)";
		$result2 = mysql_query($query_question) or die("Query failed:3");
		echo($query_question);
	}
?>