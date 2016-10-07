<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	mysql_query('SET NAMES utf8');
	$user_id= $_GET['user_id'];
	$parent_mod= $_GET['parent_mod'];

	$query = "SELECT  id,name, description, date_in FROM shed_name_id where user_id=$user_id and date_out='0000-00-00' ORDER BY `date_in` ASC";
	$result2 = mysql_query($query) or die('$query Query failed3');
		if ($parent_mod==0){
$user_id=0;
	}	
	echo('<br><table>');
	while (list($sched_id, $name, $description,$date_in) = mysql_fetch_row($result2) ){

		echo("<tr><td><a  class='ui-btn ' onclick='show_schedule($sched_id,$user_id);'>$name</a></td>"
		."<td><a class='ui-btn ' onclick='edit_schedule($sched_id);'>Ред</a></td>"
		."<td><a class='ui-btn '>$description</a></td>"
		."<td><a class='ui-btn '>$date_in</a></td>"
		."<td><a  class='do_task ui-btn  '><span sched_id=$sched_id class='trash5 ui-icon ui-icon-trash '></span></a></td>"
		."</tr>"
		);
		}
	echo ("</table>");
?>