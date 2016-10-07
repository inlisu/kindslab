<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];
	$query = "SELECT rules.rule, violation.date_creation, violation.id, violation.money, rules.id FROM violation left join rules on rule_id=rules.id where rules.user_id=$user_id and date_paid='0000-00-00 00:00:00'";
	$result2 = mysql_query($query) or die(" $query Query failed3");echo('<br><table>');
	while (list($rule_name, $date,$viol_id, $money, $rule_id) = mysql_fetch_row($result2) ){
	 $date=substr($date, 5, 11);
		echo("<tr><td><li><a  class='do_task ui-btn' onclick='complaint($viol_id);'"
		.">$rule_name</a></li></td><td><li><a  class='do_task ui-btn'>$date</a></li>
		</td><td><li><a  class='do_task ui-btn '>$money</a></li></td><td class='trash6' viol_id=$viol_id>
		<a  class='do_task ui-btn  '><span >DEL</span></a>
		</td></tr>");
		}
	echo ("</table>");
?>