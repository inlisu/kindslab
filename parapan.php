<script src="/templates/Smartphone/js/jquery-1.11.1.min.js"></script>
<meta name="viewport" content="width=device-width">
<script type="text/javascript">

function tranz(rule_id,u_name) {
if (confirm('Назначить замечание ?')) {
	$.get("engine/modules/tech/violation.php?u_name="+u_name+"&rule_id=" +rule_id, function(data){
	alert(data);
		});
	}
}
</script>
	<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$query = "SELECT rules.id,rule,user_id, payment, hm_times   FROM `rules` where date_end='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='illya') ORDER BY `rules`.`rule` ASC";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table border=3>');echo("<tr style='background:red' ><td><div align=center style='font-size: 25pt;'>ИЛЬЯ</div></td></tr>");
	while (list($rule_id, $rule_name, $user_id, $payment, $hm_times) = mysql_fetch_row($result2) )
	{
		echo("<tr onclick='tranz($rule_id,".'"'.'illya'.'"'.")'><td><a style='font-size: 21pt;'".">$rule_name</a></td></tr>");
	}
	echo ("</table>");
	
	$query = "SELECT rules.id,rule,user_id, payment, hm_times   FROM `rules` where date_end='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='Ann') ORDER BY `rules`.`rule` ASC";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table border=3>');echo("<tr style='background:red'><td><div align=center style='font-size: 25pt;'>АННА</div></td></tr>");
	while (list($rule_id, $rule_name, $user_id, $payment, $hm_times) = mysql_fetch_row($result2) )
	{
		echo("<tr onclick='tranz($rule_id,".'"'.'Ann'.'"'.")'><td><a  style='font-size: 21pt;'".">$rule_name</a></td></tr>");
	}
	echo ("</table>");
?>