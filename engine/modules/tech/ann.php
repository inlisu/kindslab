<script src="/templates/Smartphone/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
function tranz(rule_id) {
if (confirm('Хотите выставить замечание??')) {
		$.get("violation.php?u_name="+'Ann'+"&rule_id=" +rule_id, function(data){
		alert(data);
		});
	}
}
	</script>
	<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= 'Ann';
	$ctrl= 1;
	$query = "SELECT rules.id,rule,user_id, payment, hm_times   FROM `rules` where date_end='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='$u_name')";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table border=3>');
	if ($ctrl==1){
	$func="tranz";
	}
	else {
		$func="tranz1";
	}
	while (list($rule_id, $rule_name, $user_id, $payment, $hm_times) = mysql_fetch_row($result2) )
	{
		echo("<tr><td><a onclick='$func($rule_id)' style='font-size: 25pt;'".">$rule_name</a></td></tr>");
	}
	echo ("</table>");
?>