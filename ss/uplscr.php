<?php
$font = 'arial.ttf';
$dfdf=$_POST['username'];
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/init.php';
// Get current task name by username
$query = "
SELECT   common_action.name
FROM     dle_users
         INNER JOIN log_action
             ON dle_users.user_id = log_action.user_id
         INNER JOIN common_action
             ON log_action.task_id = common_action.id
WHERE    dle_users.name = '$dfdf'
ORDER BY log_action.id DESC LIMIT 1";
$result = mysql_query($query) or die("Query failed33");
list ($task_name) = mysql_fetch_row ($result);
// Move original image
$original ="uploads/" . $dfdf . "/scr/" . date('H-i-s') . '.jpg';
echo $original;
move_uploaded_file($_FILES["filename"]["tmp_name"],$original);
// Open original image
$origImage = imagecreatefromjpeg($original);
// Create an image for a timestamp
$timestampImage = imagecreatetruecolor(500, 24);
// Write the timestamp
  imagettftext(
    $timestampImage, // как всегда, идентификатор ресурса
    13, // размер шрифта
    0, // угол наклона шрифта
    2, 18, // координаты (x,y), соответствующие левому нижнему углу первого символа
    0xFFFFFF, // цвет шрифта
    $font, // имя ttf-файла
    date('H:i', time()) . " - ". $dfdf . " - " . $task_name // текст
  );
// Put timestamp image on top of original image
imagecopymerge($origImage, $timestampImage, 0, 0, 0, 0, 500, 24, 53);
imagejpeg($origImage,$original);
echo "OK";
?>