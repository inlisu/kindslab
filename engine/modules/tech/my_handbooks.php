<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$user_id= $_GET['user_id'];

	$query = "SELECT id, name, author, year   FROM handbooks where date_out='0000-00-00 00:00:00' and user_id=$user_id";
	$result2 = mysql_query($query) or die("Query failed3");
			echo("<option id=0></option>");
	while (list($id, $name,$author, $year) = mysql_fetch_row($result2) ){
		echo("<option id=hand$id> $name $author $year</option>");
		}
?>