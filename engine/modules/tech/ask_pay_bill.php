<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$viol_id= $_GET['viol_id'];
	$query = "SELECT money FROM dle_users where name='$u_name'";
	$result1 = mysql_query($query) or die("Query failed3");
	$p=mysql_fetch_row($result1);
    $money = $p[0];
 	$query = "SELECT money FROM violation where id=$viol_id and date_paid='0000-00-00 00:00:00'";
	$result2 = mysql_query($query) or die("Query failed3");
	$p=mysql_fetch_row($result2);
    $payment = $p[0];
	if (is_null($payment)){
	exit ("already paid");
	}
	if ($money >= $payment){
	$money=$money-$payment;
 	$query = "update dle_users set money=$money where name='$u_name'";
	$result1 = mysql_query($query) or die("Query failed54");
 	$query = "update violation set date_paid=now() where id=$viol_id";
	$result1 = mysql_query($query) or die("Query failed55");
	echo ("Violation paid");
	}
	else {
	echo ("Money low");
	}
?>