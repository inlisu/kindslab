<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];

	$query = "SELECT id,name,pages, link  FROM `handbooks` where date_out='0000-00-00 00:00:00' and user_id=$user_id";
	$result2 = mysql_query($query) or die("$query Query failed3");echo('<br><table>');

	while (list($id, $name, $pages, $link) = mysql_fetch_row($result2) ){
		echo("<tr><td><li><a  class='do_task ui-btn ' onclick='func($id)'"
		.">$name</a></li></td><td><li><a  class='do_task ui-btn ' onclick='kid38_click("
		.'"'
		."$id"
		.'")'
		."'"
		."'>$pages</a></li>
		</td><td><li><a  class='do_task ui-btn ' onclick='kid48_click("
		.'"'
		."$id"
		.'")'
		."'"
		."'>$link</a></li>
		
		</td></tr>");
		}
	echo ("</table>");
?>