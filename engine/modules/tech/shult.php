<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];	
	if (isset($_GET["time"])) {		//если есть параметры то закончить шульте с записью результатов

	$time= $_GET['time'];
	$query = "update  rules1 set date_end=now() where  id=$rule_id";
	$result2 = mysql_query($query) or die("$query Query failed3");
	}
	else {	//иначе закончить все начатые задачи, создать шульте и отдать таблицу
	
	$query = "update  log_action set time_end=now() where  user_id=$user_id and time_end='0000-00-00 00:00:00'";
	$result2 = mysql_query($query) or die("$query Query failed3");
	$query = "select  result from log_action where  user_id=$user_id and task_id=4 ORDER BY id DESC LIMIT 1";
	$result1= mysql_query($query) or die("$query Query failed3");
	$p=mysql_fetch_row($result1);
//	echo $p[0];
	if ($p[0]) $ch=1; else $ch=0;
	echo ('<style>.table  {border-collapse:collapse;}.table td,th,tr{border: solid 1px #333; font-size:35px; color:#112642; text-align:center;}.table td{width:90px; height:90px;}
	@media screen and (max-width: 600px) {.table td{height:50px; width:50px;}}
</style>
<table class="table" style=" max-width: 520px; background: white; display:inline-block; vertical-align: middle;">
<tr><td id="t_1_1"></td><td id="t_1_2"></td><td id="t_1_3"></td><td id="t_1_4"></td><td id="t_1_5"></td></tr> 
<tr><td id="t_2_1"></td><td id="t_2_2"></td><td id="t_2_3"></td><td id="t_2_4"></td><td id="t_2_5"></td></tr> 
<tr><td id="t_3_1"></td><td id="t_3_2"></td><td id="t_3_3"></td><td id="t_3_4"></td><td id="t_3_5"></td></tr> 
<tr><td id="t_4_1"></td><td id="t_4_2"></td><td id="t_4_3"></td><td id="t_4_4"></td><td id="t_4_5"></td></tr> 
<tr><td id="t_5_1"></td><td id="t_5_2"></td><td id="t_5_3"></td><td id="t_5_4"></td><td id="t_5_5"></td></tr> 
<div id="current" style="font-size: 35px; margin-left: auto;margin-right: auto;
    width: 99%;"></div> '."<div id='hiddd' chfree= $ch></div>".'</table>');
}
?>