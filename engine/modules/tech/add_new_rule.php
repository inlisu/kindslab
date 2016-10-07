<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$rule_name= $_GET['rule_name'];	

	$query = "insert INTO rules ( rule, user_id, date_start, creator_id, payment, hm_times,max) values ('$rule_name',(SELECT user_id from dle_users where name='$u_name'),now(),(SELECT user_id from dle_users where name='$u_name'),10,0,30)";
	$result2 = mysql_query($query) or die("Query failed3");
	echo('������� ���������');
//	echo('</ul>'); 
?>