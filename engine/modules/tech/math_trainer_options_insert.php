<link href="/templates/Smartphone/css/engine.css" rel="stylesheet">
<link href="/templates/Smartphone/css/style.css" rel="stylesheet">
<script src="/templates/Smartphone/js/libs.js" type="text/javascript"></script>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link media="screen" href="/templates/Smartphone/css/jquery.mobile-1.4.3.min.css" type="text/css" rel="stylesheet" />
<script src="/templates/Smartphone/js/jquery.mobile-1.4.3.min.js" type="application/x-javascript" charset="utf-8"></script>
<style type="text/css" media="screen">@import "/templates/Smartphone/css/style1.css";</style>	 
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
	$query = "SELECT math.link, math.action FROM math ORDER BY math.id ASC";
	$result2 = mysql_query($query) or die("Query failed3");
	echo('<ul data-role="listview" data-inset="true" data-theme="a">');
	while (list($link1, $action) = mysql_fetch_row($result2)){
		$str="<li><a onclick=math_trainer('$link1')>$action</a></li>";
		echo $str;
	}
	echo('</ul>');
?>