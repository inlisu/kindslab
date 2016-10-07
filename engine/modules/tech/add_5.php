<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];
	$add_= $_GET['add'];
	$query = "update dle_users  set money=money+$add_ where user_id=$user_id";    echo("ok");
	$result2 = mysql_query($query) or die("Query failed:3");
		$query = "INSERT INTO pay_log (money,date_in,rule_id,user_id,sender_id,	coment ) VALUES ($add_,Now(),'',0,$user_id,'')";    echo("ok");
	$result2 = mysql_query($query) or die("Query failed:3");
?>