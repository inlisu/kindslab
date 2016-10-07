<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$sched_id= $_GET['sched_id'];
	$user_id= $_GET['user_id'];	
	$query = "SELECT   description, common_action.name, schedule.id, duration, shed_id, task_id, how_many, done, 	abandon, 	late,	sequence, DATE_FORMAT(deadline,'%H:%i')  FROM `schedule` left join common_action on task_id=common_action.id where shed_id=$sched_id ORDER BY `schedule`.`sequence` ASC";
	$result2 = mysql_query($query) or die("$query Query failed3");
	echo("<ul id='sortable'>");
	while (list( $description,$name,$schedule,$duration,$id,$task_id,$how_many,$done,$abandon,$late,$sequence,$deadline) = mysql_fetch_row($result2) ){
		echo("<li class='ui-state-default str_sched'><input class='task_name inp_fild' id=$task_id  sched_id=$id value='$name' size=25><input class='inp_fild'  value='$description' size=40><input class='inp_fild' value='$how_many' size=3><input class='inp_fild' value='$duration' size=3><input class='inp_fild' value='$deadline' size=2><input class='inp_fild' value='$done' size=2><input class='inp_fild' value='$abandon' size=3><input class='inp_fild' id=late$id value='$late' size=3>11<span  class='trash ui-icon ui-icon-trash '>1</span></li>");
		}
echo("</ul><a class='ui-btn' onclick='add_row();'>Добавить строку</a>123321231<select style='width:290px' class=sel_task><option></option>");
	$query = "SELECT id, name FROM `common_action` where creator_id=$user_id and active =1 ORDER BY `name` ASC ";
	$result2 = mysql_query($query) or die("$query Query failed3");
	while (list( $task_id,$name) = mysql_fetch_row($result2) ){
	echo("<option id=$task_id class=sel_>$name</option>");
	}
	echo("</select>");
?>