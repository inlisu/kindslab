<script src="/templates/Smartphone/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
function tranz(rule_id, u_name) {
if (confirm('Замечание для '+u_name+ '?')) {
	$.get("violation.php?u_name="+u_name+"&rule_id=" +rule_id, function(data){
	alert(data);
		});
	}
}
	</script>
	<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$query = "SELECT rules.id,rule,user_id, payment, hm_times   FROM `rules` where date_end='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='illya')";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table border=3>');echo("<tr><td><div align=center style='font-size: 25pt;'>ИЛЬЯ</div></td></tr>");
	while (list($rule_id, $rule_name, $user_id, $payment, $hm_times) = mysql_fetch_row($result2) )
	{
		
		echo("<tr><td><a onclick='tranz($rule_id,'illya')' style='font-size: 21pt;'".">$rule_name</a></td></tr>");
	}
	echo ("</table>");
	
		$query = "SELECT rules.id,rule,user_id, payment, hm_times   FROM `rules` where date_end='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='Ann')";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table border=3>');echo("<tr><td><div align=center style='font-size: 25pt;'>АННА</div></td></tr>");
	while (list($rule_id, $rule_name, $user_id, $payment, $hm_times) = mysql_fetch_row($result2) )
	{
		
		echo("<tr><td><a onclick='tranz($rule_id,'Ann')' style='font-size: 21pt;'".">$rule_name</a></td></tr>");
	}
	echo ("</table>");
?>