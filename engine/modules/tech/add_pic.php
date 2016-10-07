<?php

// The standard header for json data:
header('Content-type: application/json');
$last_scr = $_GET['last_scr'];
$last_cam = $_GET['last_cam'];
$u_name = $_GET['u_name']
// 
$cam = glob('uploads/'.$u_name.'/cam/*.jpg');
$scr = glob('uploads/'.$u_name.'/scr/*.jpg');

if(!$scr && !$cam){
	$cam = array();
	$scr = array();
}
asort($cam);
asort($scr);

array_splice($cam,  array_search('green', $cam));
array_splice($scr,  array_search('green', $scr));




echo json_encode(array('cam' => $cam,'scr'	=> $scr));

?>