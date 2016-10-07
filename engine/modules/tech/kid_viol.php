<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];
	$query = "SELECT violation.id, rule, DATE_FORMAT(date_creation,'%H:%i'),DATE_FORMAT(date_paid,'%m:%i'), money FROM `violation` left join rules on rules.id= rule_id where rules.user_id='$user_id' and CURDATE()<date_creation";
	$result2 = mysql_query($query) or die("Query failed3");
echo('<br><table>');
	while (list($violation_id, $rule, $in, $out, $money) = mysql_fetch_row($result2) ){
		echo("<tr><td><li><a  class='do_task ui-btn' onclick=del_viol($violation_id)>$rule </a></li></td>
		<td><li><a class='do_task ui-btn' onclick=_click1($user_id)>$in</a></li></td>
		<td><li><a class='do_task ui-btn' onclick=_viol($user_id)>$out </a></li></td><td><li><a  class='do_task ui-btn' onclick='_click("
		.'"'
		."$user_id "
		.'")'
		."'"
		."'>$money</a></li></td></tr>"
		); 
	}
	echo ("</table>$query");
?>