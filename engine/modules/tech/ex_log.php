<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$log_id= $_GET['log_id'];
	$query = "SELECT  DATE_FORMAT(time_start,'%H:%i:%s') FROM log_action where id=$log_id";
	$result2 = mysql_query($query) or die('$query Query failed3');
	$p=mysql_fetch_row($result2);
    $time_start = $p[0];
	$query = "SELECT  ex, DATE_FORMAT(date,'%H:%i:%s') as t_end from ex_log where log_id=$log_id";
	$result2 = mysql_query($query) or die('$query Query failed3');
	echo("<br><table><tr><td colspan=2><a class='ui-btn '>$time_start</a></td></tr>");
	$aaa=$time_start;
	while (list($ex, $t_end) = mysql_fetch_row($result2) ){
		$bbb= $t_end;
 		$a=explode(":",$aaa);
		$b=explode(":",$bbb);
		$ccc=$b[0]*3600+$b[1]*60+$b[2]-$a[0]*3600-$a[1]*60-$a[2]; 
		echo("<tr><td><a  class='ui-btn '>$ex</a></td>"
		."<td><a class='ui-btn '>$ccc сек</a></td>"
		."</tr>"
		);
		$aaa=$bbb;
	}
	echo ("<tr><td colspan=2><a class='ui-btn '>$bbb</a></td></tr></table>");
?>