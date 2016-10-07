<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$rule_id= $_GET['rule_id'];
	
	$query = "SELECT dle_users.user_id, (money- ind_discount)   FROM `rules` left join dle_users on rules.user_id=dle_users.user_id where  id=$rule_id";
	$result2 = mysql_query($query) or die("Query failed2");
	$p=mysql_fetch_row($result2);
    $user_id = $p[0];
    $balance = $p[1];
	if ($balance>=0){
	$query = "update rules set indulgence= indulgence+1, indul_date=now()  where  id=$rule_id";
	$result2 = mysql_query($query) or die("Query failed3");
	
	$query = "update dle_users  set money=$balance where user_id=$user_id";    
	$result2 = mysql_query($query) or die("Query failed:4");
	echo('Done');
	}
else  echo('No money!');
?>	