<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	$plans_ids= $_GET['plans_ids'];
	$plans_ids_ = explode(":",$plans_ids);
	while (list($key, $plan_id) = each($plans_ids_)) {
		$query = "UPDATE plans SET complete=date(NOW()) WHERE id = $plan_id";
		$result = mysql_query($query) or die("Query failed:3");
	}
	echo('SSS');
?>