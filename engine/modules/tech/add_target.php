<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_POST['user_id'];
	$target_name= $_POST['name'];	
	$target_desc= $_POST['desc'];
	$deadline= $_POST['deadline'];
	$manual_id= $_POST['id'];
	$query = "insert INTO projects ( name, user_id, date_started, deadline, description, manual_id) values ('$target_name',$user_id,now(),'$deadline','$target_desc','$manual_id')";
	$result2 = mysql_query($query) or die("Query failed3");
	echo('Цель добавлена');
?>