<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$id = $_GET['id'];
	$condition = $_GET['condition'];
	
	if($condition == '0'){
		$condition = '1';
	}
	else{
		$condition = '0';
	}
	$query = "UPDATE management SET state = '$condition' WHERE id = '$id'";
	$result = mysql_query($query) or die ($query);
	echo('ok');
?>