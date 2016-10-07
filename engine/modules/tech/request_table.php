<script type="text/javascript" language="javascript">
	$(document).ready(ready_1);
	function ready_1(){
		$('.request_approve').click(function () {
			var local_schedule = $(this).attr('schedule');
			str='?&sch=' + local_schedule + '&status=1';
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open('GET', 'engine/modules/tech/request_changer.php'+str, true);
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4) {
					if(xmlhttp.status == 200) {
						$('[schedulefade='+local_schedule+']').fadeOut("slow");
					}
				}
			}
			xmlhttp.send(null);
		});
		$('.request_reject').click(function () {
			var local_schedule = $(this).attr('schedule');
			str='?&sch=' + local_schedule + '&status=3';
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open('GET', 'engine/modules/tech/request_changer.php'+str, true);
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4) {
					if(xmlhttp.status == 200) {
						$('[schedulefade='+local_schedule+']').fadeOut("slow");
					}
				}
			}
			xmlhttp.send(null);
		});
	}
</script>
		<table class="schedule_table">
			<tr>
				<td class="schedule_td">                              Описание задачи                           </td>
				<td class="schedule_td"> Запланировано на </td>
				<td class="schedule_td">      Поставивший задачу      </td>
				<td class="schedule_td">Перенос задачи</td>
				
			</tr>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
	
	$query = "SELECT for_date, time_start, postpone, how_much, tasks.name, subcase_id, schedule.comment, plan_id, fullname, user_group, schedule.id, math.link, math.action, test_groups.short_description, schedule.auto, schedule_daily.name FROM schedule LEFT JOIN plans ON plan_id = plans.id LEFT JOIN tasks ON task_id = tasks.id LEFT JOIN dle_users ON user_id = schedule.submitter_id LEFT JOIN math ON math.id = schedule.comment LEFT JOIN test_groups ON test_groups.id = schedule.comment LEFT JOIN schedule_daily ON schedule_daily.id=plans.comment WHERE time_end = 0 AND request = 2";
	$result2 = mysql_query($query) or die("Query failed3"); 
	while (list($for_date, $time_start, $postpone, $how_much, $name_of_task, $subcase_id, $comment, $plan_id, $fullname, $user_group_tb1, $schedule_id, $link, $action, $description, $auto, $daily_name) = mysql_fetch_row($result2) ) {
		switch ($plan_id){
			case "0" : {
				$type_for_order = 'show_dialog';
				$str="<tr schedulefade='$schedule_id'>
				<td class='schedule_td'><span schedule='$schedule_id' schedulefor='$schedule_id' name_for_tb2='$comment' href='#' link='#' type=order>$comment</span></td>
				<td class='schedule_td'>      $for_date</td>
				<td class='schedule_td' group='$user_group_tb1'>$fullname</td>
				<td class='schedule_td'><button class='request_approve' schedule='$schedule_id'>Подтвердить</button>     <button class='reqeust_reject' schedule='$schedule_id'>Запретить</button></td></tr>";
				echo $str;
				break;
			}
			case "4" : {
				$str="<tr schedulefade=$schedule_id>
				<td class='schedule_td'><span name_for_tb2='$action' schedulefor='$schedule_id' schedule='$schedule_id' href='#' link='#' type='math'>$action</span></td>
				<td class='schedule_td'>      $for_date</td>
				<td class='schedule_td' group='$user_group_tb1'>$fullname</td>
				<td class='schedule_td'><button class='request_approve' schedule='$schedule_id'>Подтвердить</button>     <button class='reqeust_reject' schedule='$schedule_id'>Запретить</button></td></tr>";
				echo $str;
				break;
			}
			default : {
				if ($auto==0){
					$str="<tr schedulefade='$schedule_id'>
					<td class='schedule_td'><span schedulefor='$schedule_id' planfor='$plan_id' subcase_id='$subcase_id' name_for_tb2='$name_of_task $how_much задач $comment' schedule='$schedule_id' href='#' link='#' type=hbook>$name_of_task $how_much задач $comment</span></td>
					<td class='schedule_td'>      $for_date</td>
					<td class='schedule_td' group='system'>System</td>
					<td class='schedule_td'><button class='request_approve' schedule='$schedule_id'>Подтвердить</button>     <button class='reqeust_reject' schedule='$schedule_id'>Запретить</button></td></tr>";
					echo $str;
				}
				else{
					$str="<tr schedulefade='$schedule_id'>
					<td class='schedule_td'><span schedulefor='$schedule_id' name_for_tb2='$daily_name' schedule='$schedule_id' href='#' link='#' type=order>$daily_name</span></td>
					<td class='schedule_td'>      $for_date</td>
					<td class='schedule_td' group='system'>System</td>
					<td class='schedule_td'><button class='request_approve' schedule='$schedule_id'>Подтвердить</button>     <button class='reqeust_reject' schedule='$schedule_id'>Запретить</button></td></tr>";
					echo $str;
				}
				break;
			}
		}
	}
?>
</table>
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