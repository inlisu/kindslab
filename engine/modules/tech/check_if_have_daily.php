<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$user_id=$_GET["u_id"];
	
	$query = "SELECT * FROM schedule WHERE performer_id = $user_id AND auto = 1 AND time_end = 0";
	$result = mysql_query($query) or die ('Query failed :3');
	if(mysql_num_rows($result) == 0){
		echo('Access allowed');
	}
	else{
		echo('Access denied');
	}
?>