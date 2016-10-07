<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';

	$u_id = $_GET['u_id'];
	
	$query = "SELECT name, readbooks.id, task_id FROM plans LEFT JOIN readbooks ON readbooks.id = plans.comment WHERE performer_id = '$u_id' AND complete = 0 AND auto = '2'";
	$result = mysql_query($query) or die ('Query failed :O');
	$id = mysql_result($result, 0, 1);
	$book = mysql_result($result, 0, 0);
	$percent = mysql_result($result, 0, 2)*1;
	$percent_for_button = $percent + 25;
	if($percent_for_button == 100){
		$percent_for_button_last = "Закончить книгу";
	}
	else{
		$percent_for_button_last = "Прочитано на $percent_for_button %";
	}
	if(mysql_num_rows($result) !== 0){
		echo("<span id='current_book'>Сейчас вы читаете '$book'</span>");
		echo(" Прочитано на<span id='current_book_percent'> $percent</span>%");
		echo("<button id='current_book_button' value='$id' percent='$percent'>$percent_for_button_last</button>");
	}
?>
<script>
	$('#current_book_button').click(function () {
		var percent = $("#current_book_button").attr('percent')*1;
		var id = $("#current_book_button").val();
		var u_id = <?php echo ($u_id); ?>;
		var str = '?id='+id+'&u_id='+u_id+'&percent='+percent;
		if((percent + 25) == 100){
			$("#current_book_button").fadeOut('slow');
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open('GET', 'engine/modules/tech/readbook_read.php'+str, true);
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4) {
					if(xmlhttp.status == 200) {
						percent = percent + 25;
						$("#current_book_button").attr('percent', percent);
						$("#current_book_percent").text(' ' + percent);
						$("#tb4_table").fadeIn('slow');
						$("#tb4_books").fadeIn('slow');
					}
				}
			}
			xmlhttp.send(null);
		}
		else{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open('GET', 'engine/modules/tech/readbook_read.php'+str, true);
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4) {
					if(xmlhttp.status == 200) {
						percent = percent + 25;
						percent_25more = percent + 25;
						$("#current_book_button").attr('percent', percent);
						$("#current_book_percent").text(' ' + percent);
						$("#current_book_button").text('Прочитано на ' + percent_25more + '%');
					}
				}
			}
			xmlhttp.send(null);
		}
	});
</script>