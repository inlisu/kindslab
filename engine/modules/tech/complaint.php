<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$compl= $_POST['compl'];
	$violation_id= $_POST['violation_id'];
	$query = "update violation set complaint='$compl' where id=$violation_id";
		echo($query);
	$result2 = mysql_query($query) or die("Query failed3");
	echo('Complaint inserted');
?>