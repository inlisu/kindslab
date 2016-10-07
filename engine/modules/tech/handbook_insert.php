<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	$usr_id= $_GET['usr_id'];
	$age= $_GET['age'];
	$name= $_GET['name'];
	$author= $_GET['author'];
	$year= $_GET['year'];
	$lang_id= $_GET['lang_id'];
	$pages= $_GET['pages'];
	$exercises= $_GET['exercises'];
	$link= $_GET['link'];
	$query = "INSERT INTO handbooks (age, name, author, year, lang_id, pages, exercises, link) VALUES('$age', '$name', '$author', '$year', '$lang_id', '$pages', '$exercises', '$link')";
	$result = mysql_query($query) or die("Query failed:3");
	$query2 = "SELECT id FROM handbooks ORDER BY id DESC LIMIT 0 , 1";
	$result2 = mysql_query($query2) or die("Query failed:3");
	$subcase_id = mysql_result($result2,0);
	$query3 = "INSERT INTO tasks (case_, name, subcase_id, php, creator_id, age) VALUES('handbooks', '$name', '$subcase_id', 'hbook', '$usr_id', '$age')";
	$result3 = mysql_query($query3) or die("Query failed:3");
?>