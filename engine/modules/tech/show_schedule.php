<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];
	$sched_id= $_GET['sched_id'];
	$parent_mod= $_GET['parent_mod'];
	$f1="";
	$f2="non";
	$f3="";
	$f4="";
	$f5="";
	if ($parent_mod==1){
	$f1='onclick="correct_time($id)"';
	$f2='check';
	$f3='onclick="check($id,0)"';
	$f4='onclick="check($id,-1)"';
	$f5='onclick="set_hm($id)"';
	}
	$time_m=0;
	$query = "SELECT delta FROM `dle_users`  where user_id=$user_id";
	$result2 = mysql_query($query) or die("$query Query failed3");	
	$p=mysql_fetch_row($result2);
    $delta = $p[0];
	date_default_timezone_set('America/Los_Angeles');
	$ti=date('h:i');
	
	$query = "SELECT schedule.id, duration,task_id,common_action.name, description,how_many,done,late,abandon, logic_id,  DATE_FORMAT(deadline,'%H:%i') FROM `schedule` left join common_action on common_action.id=task_id where shed_id=$sched_id ORDER BY `schedule`.`sequence` ASC";
	$result2 = mysql_query($query) or die("$query Query failed3");echo('<br><table>');

	
	while (list($id, $duration, $task_id, $name, $description, $how_many, $done, $late, $abandon, $logic_id, $deadline) = mysql_fetch_row($result2) ){
//		date_add($ti, date_interval_create_from_date_string($time_m .' minutes'));
		$time=$ti;
		echo("<tr><td colspan='4'><a task=wait id=sch$id class='ui-btn ' onclick='sch_task_start($id,$task_id,$logic_id, $done, $late, $abandon)'>$name</a></td><td colspan='4' class=><a class=' ui-btn ' onclick='func($task_id) 'id=hm$id >$description</a></td></tr>");
		echo("<tr><td ><a class=' ui-btn ' >$how_many</td>");
		echo("<td ><a class=' ui-btn ' id=ti$id  $f1>$time</td>");
		echo("<td ><a class=' ui-btn ' id=dl$id onclick='func11($task_id)'>$deadline</td>");
		echo("<td ><a class=' ui-btn ' id=du$id > </td>");
		echo("<td width='60'><a class='ui-btn' onclick='func($task_id)'>$duration</td>");		
		echo("<td width='60'><a id=done$id class=' ui-btn ' onclick='$f2($id,1)'>$done</a></td>");
		echo("<td width='60'><a class=' ui-btn ' onclick='$f2($id,0)'>$late</a></td>");
		echo("<td width='60'><a class=' ui-btn ' onclick='$f2($id,-1)'>$abandon</a></td></tr>");
		$time_m=$duration;
		}
	echo ("</table>");
?>