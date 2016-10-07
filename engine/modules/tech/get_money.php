<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$query = "select money from dle_users where name='$u_name'";
	$result2 = mysql_query($query) or die("Query failed3");
	$p=mysql_fetch_row($result2);
    $deb = $p[0];
	$query = "SELECT sum(money),count(violation.id),(SELECT user_id from dle_users where name='$u_name') as user_id FROM `violation` left join rules on rule_id = rules.id where date_paid='0000-00-00 00:00:00' and rules.user_id=(SELECT user_id from dle_users where name='$u_name')";
	$result3 = mysql_query($query) or die("Query failed4");
	$p=mysql_fetch_row($result3);
    $cred = $p[0];
    $hm = $p[1];
	$user_id = $p[2];
	echo("$deb,$cred,$hm,$user_id");
?>