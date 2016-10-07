<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$u_name= $_GET['u_name'];
	$ctrl= $_GET['ctrl'];
	$query = "SELECT rules.id,rule,user_id, payment, hm_times   FROM `rules` 
              where date_end='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='$u_name')";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table>');
	if ($ctrl==1){
	$func="tranz";
	}
	else {
		$func="tranz1";
	}
	while (list($rule_id, $rule_name, $user_id, $payment, $hm_times) = mysql_fetch_row($result2) ){
		echo("<tr><td><li><a  class='do_task ui-btn ' onclick='$func($rule_id)'"
		.">$rule_name</a></li></td><td><li><a  class='do_task ui-btn ' onclick='kid3_click("
		.'"'
		."$user_id"
		.'")'
		."'"
		."'>$payment</a></li>
		
		</td><td><li><a  class='do_task ui-btn ' onclick='kid4_click("
		.'"'
		."$user_id"
		.'")'
		."'"
		."'>$hm_times</a></li></td><td>
		<a  class='do_task ui-btn  '><span rule_id=$rule_id class='trash3 ui-icon ui-icon-trash '></span></a>
		
		</td></tr>");
		}
	echo ("</table>");
?>