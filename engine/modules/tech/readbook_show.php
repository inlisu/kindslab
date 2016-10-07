<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$age = $_GET['age'];
	$u_id = $_GET['u_id'];
	
	$query = "SELECT id, name, author, size, year FROM readbooks WHERE age = '$age'";
	$result = mysql_query($query) or die($query);
	
	echo('<tr><td>Название</td><td>   </td><td>Автор</td><td>   </td><td>Количество знаков</td><td>   </td><td>Год</td><td>   </td><td>Читать</td>');
	while (list($id, $name, $author, $size, $year) = mysql_fetch_row($result) ) {
		$query2 = "SELECT * FROM plans WHERE performer_id = '$u_id' AND comment = '$id' AND auto = '2' AND complete != '0'";
		$result2 = mysql_query($query2) or die ('QUERY FAILED MUHAHAH');
		
		if(mysql_num_rows($result2) == 0){
			echo("<tr><td>$name</td><td>   </td><td>$author</td><td>   </td><td>$size</td><td>   </td><td>$year</td><td>   </td><td><button class='readbook_read_button' value='$id'>Читать</button></td></tr>");
		}
		else{
			echo("<tr><td>$name</td><td>   </td><td>$author</td><td>   </td><td>$size</td><td>   </td><td>$year</td><td>   </td><td><span>Прочитано</span></td></tr>");
		}
	}
?>
<script>
	$(".readbook_read_button").click(function () {
		var book = $(this).val();
		var u_id = <?php echo ($u_id); ?>;
		var str = '?u_id='+u_id+'&id='+book+'&percent=0';
		//alert(str);
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open('GET', 'engine/modules/tech/readbook_read.php'+str, true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4) {
				if(xmlhttp.status == 200) {
					$("#tb4_book_start_reading").fadeIn("slow",function(){
						$("#tb4_book_start_reading").fadeOut(4000);
					});
					$("#tb4_table").fadeOut('slow');
					$("#tb4_books").fadeOut('slow');
					var xmlhttp1 = new XMLHttpRequest();
					xmlhttp1.open('GET', 'engine/modules/tech/current_book.php?u_id='+u_id, false);
					xmlhttp1.onreadystatechange = function() {
						if (xmlhttp1.readyState == 4) {
							if(xmlhttp1.status == 200) {
								$("#current_book_div").html(xmlhttp1.responseText);
							}
						}
					}
					xmlhttp1.send(null);
				}
			}
		}
		xmlhttp.send(null);
	});
</script>