<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$data= $_POST['data'];
	$name= $_POST['name'];
	$description= $_POST['description'];
	$user_id= $_POST['user_id'];
 	$query = "insert into shed_name_id  (user_id, name, description, date_in) values ($user_id, '$name', '$description', now())";
	$result2 = mysql_query($query) or die("$query Query failed3"); 
	$query = "select max(id) from shed_name_id  where user_id=$user_id GROUP BY user_id;";
	$result2 = mysql_query($query) or die("$query Query failed3");
	$p=mysql_fetch_row($result2);
    $new_sched_id = $p[0];
	$str_of_sched=explode (')!!(',$data);
	$query="";
	while (list($i, $val) = each($str_of_sched)) {
	$query =$query . "($new_sched_id,$val),";
}	    
	$query = "insert into schedule (shed_id,task_id,  name, description,how_many,duration,deadline,done,abandon,late,sequence) values ".substr($query,0,-8);
	$result2 = mysql_query($query) or die("$query Query failed3");
echo ("Записано");
?>