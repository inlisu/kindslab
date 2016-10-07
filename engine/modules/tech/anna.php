<html>
<head>
<title>Страница проверки новых заказов</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

<audio class="audioDemo" controls preload="none" style="display:none;">
<source src="be.mp3" type="audio/mpeg">
   <source src="audio/music.ogg" type="audio/ogg">
</audio>
</head>
<body>
<script type="text/javascript">
				$(".audioDemo").trigger('load');
$(".audioDemo").trigger('play');	
n = setTimeout("money()", 5000);			
					function money() {
					alert("lll");
					$(".audioDemo").trigger('pause');
}
</script>
</body>
</html>