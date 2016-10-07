<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$name= $_GET['name'];
	$age= $_GET['age'];
	$author= $_GET['author'];
	$year= $_GET['year'];
	$pages= $_GET['pages'];
	
	$query = "INSERT INTO readbooks (age, name, author, year, size) VALUES('$age', '$name', '$author', '$year', '$pages')";
	$result = mysql_query($query) or die($query);
	
	
?>