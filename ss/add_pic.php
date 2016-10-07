<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
// The standard header for json data:
header('Content-type: application/json');
$last_scr = $_GET['last_scr'];
$last_cam = $_GET['last_cam'];
$u_name = $_GET['u_name'];
// 
$cam = glob('uploads/'.$u_name.'/cam/*.jpg');
$scr = glob('uploads/'.$u_name.'/scr/*.jpg');


/* if(!$scr && !$cam){
	$cam = array();
	$scr = array();
} */
foreach($cam as $key => $value) { // $key - индекс элемента массива, $value - значение элемента массива
   $cam[$key] = substr ($value,-12);
}
foreach($scr as $key => $value) { // $key - индекс элемента массива, $value - значение элемента массива
   $scr[$key] = substr ($value,-12);
}

rsort($cam);
rsort($scr);  
/*   echo $last_cam . $last_scr;
 echo array_search($last_scr, $scr);
 echo array_search($last_cam, $cam); */ 
//if ($last_cam)
	array_splice($cam,   array_search($last_cam, $cam));
//if ($last_scr) 
	array_splice($scr,  array_search($last_scr, $scr));   
sort($cam);
sort($scr); 

echo json_encode(array('cam' => $cam,'scr'	=> $scr));
?>