<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];
	$query = "SELECT id,name,  DATE_FORMAT(date_started, '%d-%m-%y'), DATE_FORMAT(deadline, '%d-%m-%y'), description    FROM `projects` where date_finished='0000-00-00 00:00:00' and user_id=$user_id";	
	$result2 = mysql_query($query) or die("Query failed3 $query");echo('<br><table>');

	$func="show_target_descr"; 

	while (list($id, $name, $date_started, $deadline, $description) = mysql_fetch_row($result2) ){
		$description1=substr($description,0,41);
		echo("<tr><td><li><a  class='do_task ui-btn ' onclick='$func($id)'"
		.">$name</a></li></td><td><a onclick='alert("
		.'"'
		."$description"
		.'"'
		.");' class='do_task ui-btn '"
		.">$description1</a></td><td><li><a  class='do_task ui-btn ' onclick='kid3_click("
		.'"'
		."$user_id"
		.'")'
		."'"
		."'>$date_started</a></li>

		</td><td><li><a  class='do_task ui-btn ' onclick='kid4_click("
		.'"'
		."$user_id"
		.'")'
		."'"
		."'>$deadline</a></li></td><td>
		<a  class='do_task ui-btn  '><span target_id=$id class='trash2 ui-icon ui-icon-trash '></span></a>
		
		</td></tr><tr><td colspan=2><a  class='do_task ui-btn '"
		."></a></td><td><a  class='do_task ui-btn ' "
		."></a></td><td><a  class='do_task ui-btn '"
		."></a></td><td><a  class='do_task ui-btn '"
		."></a></td></tr>");
		}
	echo ("</table>");
?>