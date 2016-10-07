<?php
    /* Init Errors && DB */
	require_once 'includes/init.php';

	$u_name		= addslashes($_GET['u_name']);
	$rule_id	= (int)$_GET['rule_id'];

	$query = "  select payment, hm_times, max, (UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(indul_date)), ind_discount 
				from rules   
				where  id='".$rule_id."'";

	$result2 = mysql_query($query) or die("Query failed3");

	$p=mysql_fetch_row($result2);
    $payment = $p[0];
	$hm_times = $p[1];
	$max = $p[2];
	$min_left = $p[3];
	$ind_discount = $p[4];
	$money = $payment*$hm_times;
	if ($money>$max) $money=$max;

			$query1 = "insert INTO violation (rule_id, user_id, date_creation,  money) values ('$rule_id',(SELECT user_id from dle_users where name='$u_name'),now(),$money)";
			$result2 = mysql_query($query1) or die("Query failed6");
			$query = "update rules set hm_times=hm_times+1  where id=$rule_id";
			$result2 = mysql_query($query) or die("Query failed7");
			echo(" Violation inserted");
?>
