<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
    $sql='';
	$u_group = $_GET['u_group'];
	$u_id = $_GET['u_id'];
?><html>
	<head>
		<title>
			Jack
		</title>
		<script type="text/javascript" language="javascript">
			$(document).ready(ready_1);
			function ready_1(){
				var usr_gr = <?php echo ($u_group); ?>;
				$('#postpone_button').click(function () {
					var local_schedule = this_schedule_id;
					var comment_for_request = $("#comment_for_request_text").val();
					var date = $('#f_date_c_tb1').val();
					str="?date=" + date + '&sch=' + this_schedule_id + '&user_group=' + usr_gr;
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/postpone_schedule.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								if(usr_gr !== 6){
									$('[schedulefade='+local_schedule+']').fadeOut("slow");
								}
								else{
									alert('Запрос на откладывание отправлен');
								}
								$("#tb1_hidden_calendar").dialog("close");
							}
						}
					}
					xmlhttp.send(null);
				});
				$('.postpone').click(function () {

					$('#tb1_hidden_calendar').dialog();
					this_schedule_id = $(this).attr('schedule');
				});
			}
		</script>
		<style>
			a {
				text-decoration : none;
			}
			td[group="1"] {
				background : #EED5D2;
			}
			td[group="2"] {
				background : #EED5D2;
			}
			td[group="3"] {
				background : #EED5D2;
			}
			td[group="6"] {
				background : #C1FFC1;
			}
			td[group="5"] {
				background : #C1FFC1;
			}
			td[group="4"] {
				background : #C1FFC1;
			}
			td[group="system"] {
				background : #BBFFFF;
			}
			.schedule_td{
				border : 3px groove #D1EEEE;
			}
			.schedule_table {
				border : 3px groove #D1EEEE;
			}
			
		</style>
	</head>
	<body>
		<table class="schedule_table">
			<tr>
				<td class="schedule_td">                              Описание задачи                           </td>
				<td class="schedule_td">  Выполнить  </td>
				<td class="schedule_td"> Запланировано на </td>
				<td class="schedule_td">      Поставивший задачу      </td>
				<td class="schedule_td">Перенос задачи</td>
				
			</tr>
			<?php
				$query = "SELECT for_date, time_start, postpone, how_much, tasks.name, subcase_id, schedule.comment, plan_id, fullname, user_group, schedule.id, math.link, math.action, test_groups.short_description, schedule.auto, schedule_daily.name FROM schedule LEFT JOIN plans ON plan_id = plans.id LEFT JOIN tasks ON task_id = tasks.id LEFT JOIN dle_users ON user_id = schedule.submitter_id LEFT JOIN math ON math.id = schedule.comment LEFT JOIN test_groups ON test_groups.id = schedule.comment LEFT JOIN schedule_daily ON schedule_daily.id=plans.comment WHERE (schedule.performer_id = $u_id AND time_end = 0 AND postpone = date(NOW())) OR 
				(schedule.performer_id = $u_id AND time_end = 0 AND postpone < date(NOW())) OR 
				(schedule.performer_id = $u_id AND time_end = 0 AND postpone !=0 AND request > 1)";
				$result2 = mysql_query($query) or die("Query failed3"); 
				while (list($for_date, $time_start, $postpone, $how_much, $name_of_task, $subcase_id, $comment, $plan_id, $fullname, $user_group_tb1, $schedule_id, $link, $action, $description, $auto, $daily_name) = mysql_fetch_row($result2) ) {
					switch ($plan_id){
						case "0" : {
							$type_for_order = 'show_dialog';
							$str="<tr schedulefade='$schedule_id'>
							<td class='schedule_td'><span schedule='$schedule_id' schedulefor='$schedule_id' name_for_tb2='$comment' href='#' link='?u_id=$u_id&type=$type_for_order&schedule_id=' type=order>$comment</span></td>
							<td class='schedule_td'><button schedule='$schedule_id' schedulefor='$schedule_id' name_for_tb2='$comment' href='#' link='?u_id=$u_id&type=$type_for_order&schedule_id=' class=tb1_a type=order>Выполнить</button></td>
							<td class='schedule_td'>      $for_date</td>
							<td class='schedule_td' group='$user_group_tb1'>$fullname</td>
							<td class='schedule_td'>     <a href='#' class='postpone' schedule='$schedule_id'>Отложить</a></td></tr>";
							echo $str;
							break;
						}
						//case "5" : {
						//	$str='<div schedulefade=' . $schedule_id . ' class="portlet">
						//	<div class="portlet-header">' . $fullname . '</div>
						//	<div class="portlet-content"><div class=date>' . $for_date . '</div><a class=tb1_a schedule=' . $schedule_id . ' href="#" link="?group=' . $comment . '" type=test>
						//	' . $description . '</a></div><a href="#" class="postpone" schedule=' . $schedule_id . '> Отложить</a></div>';
						//	echo $str;
						//	break;
						//}
						case "4" : {
							$str="<tr schedulefade=$schedule_id>
							<td class='schedule_td'><span name_for_tb2='$action' schedulefor='$schedule_id' schedule='$schedule_id' href='#' link='" . $link . $u_id . "&schedule_id=' type='math'>$action</span></td>
							<td class='schedule_td'><button name_for_tb2='$action' class=tb1_a schedulefor='$schedule_id' schedule='$schedule_id' href='#' link='" . $link . $u_id . "&schedule_id=' type='math'>Выполнить</button></td>
							<td class='schedule_td'>      $for_date</td>
							<td class='schedule_td' group='$user_group_tb1'>$fullname</td>
							<td class='schedule_td'>     <a href='#' class='postpone' schedule='$schedule_id'>Отложить</a></td></tr>";
							echo $str;
							break;
						}
						default : {
							if ($auto==0){
								$str="<tr schedulefade='$schedule_id'>
								<td class='schedule_td'><span schedulefor='$schedule_id' planfor='$plan_id' subcase_id='$subcase_id' name_for_tb2='$name_of_task $how_much задач $comment' schedule='$schedule_id' href='#' link='?u_id=$u_id&how_much=$how_much&plan_id=' type=hbook>$name_of_task $how_much задач $comment</span></td>
								<td class='schedule_td'><button schedulefor='$schedule_id' planfor='$plan_id' subcase_id='$subcase_id' name_for_tb2='$name_of_task $how_much задач $comment' class=tb1_a schedule='$schedule_id' href='#' link='?u_id=$u_id&how_much=$how_much&plan_id=' type=hbook>Выполнить</button></td>
								<td class='schedule_td'>      $for_date</td>
								<td class='schedule_td' group='system'>System</td>
								<td class='schedule_td'>     <a href='#' class='postpone' schedule='$schedule_id'>Отложить</a></td></tr>";
								echo $str;
							}
							else{
								$str="<tr schedulefade='$schedule_id'>
								<td class='schedule_td'><span schedulefor='$schedule_id' name_for_tb2='$daily_name' schedule='$schedule_id' href='#' link='?u_id=$u_id&type=show_dialog&schedule_id=' type=order>$daily_name</span></td>
								<td class='schedule_td'><button hider='daily' schedulefor='$schedule_id' name_for_tb2='$daily_name' schedule='$schedule_id' href='#' link='?u_id=$u_id&type=show_dialog&schedule_id=' type=order class=tb1_a>Выполнить</button></td>
								<td class='schedule_td'>      $for_date</td>
								<td class='schedule_td' group='system'>System</td>
								<td class='schedule_td'>     <a href='#' class='postpone' schedule='$schedule_id'>Отложить</a></td></tr>";
								echo $str;
							}
							break;
						}
					}
				}
			?>
		</table>
	</body>
</html>