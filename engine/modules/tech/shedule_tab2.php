<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script type="text/javascript" src="engine/skins/calendar.js"></script>
<link rel="stylesheet" type="text/css" href="engine/skins/default.css?v=2">
<link rel="stylesheet" type="text/css" href="engine/skins/jquery-ui.css?v=2">
<link rel="stylesheet" type="text/css" media="all" href="engine/skins/calendar-blue.css" title="win2k-cold-1" />
<link rel="stylesheet" type="text/css" href="engine/skins/chosen/chosen.css"/>
<style>
	.rate_1{background : #00FF00;}  
	.percent{background : #00FF00;}  
    .column { width: 220px; float: left; padding-bottom: 100px; }
    .portlet { margin: 0 1em 1em 0; }
    .portlet-header { margin: 0.3em; padding-bottom: 1px; padding-left: 0.2em; }
    .portlet-header .ui-icon {float: right;}
    .portlet-content { padding: 0.4em; }
    .ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
    .ui-sortable-placeholder * { visibility: hidden; }  
</style>
<?php
	$u_id= $_GET['user_id'];
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
?>
            <div style="float: left; width: 300;">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
			</div>
            <div style="float: left; width: 300;">
				<div id="tb1_hidden_admins_chooser" hidden>
					<SELECT  id="tb1_users">
						<?php
							$query = "SELECT user_id, fullname FROM dle_users WHERE family_id = (SELECT family_id FROM dle_users WHERE dle_users.user_id = $u_id ) ORDER BY user_id ASC";
							$result2 = mysql_query($query) or die("Query failed3");
							// вывести список users кому можно ставить задачи
							while (list($user__id, $fullname) = mysql_fetch_row($result2) ) {
								$str='<option value=' . $user__id . '>' . $fullname . '</option>';
								echo $str;
							}
						?>
					</SELECT>   
					<button id = "tb1_choose_confimer">Посмотреть</button>
				</div>
				<div id="tb1_hidden_div" title='hhh' hidden>
				</div>
                <div id="tb1_div_1" class="column">
					<?php
						$query = "SELECT for_date, time_start, postpone, how_much, tasks.name, subcase_id, schedule.comment, plan_id, fullname, schedule.id, math.link, math.action, test_groups.short_description FROM schedule LEFT JOIN plans ON plan_id = plans.id LEFT JOIN tasks ON task_id = tasks.id LEFT JOIN dle_users ON user_id = schedule.submitter_id LEFT JOIN math ON math.id = schedule.comment LEFT JOIN test_groups ON test_groups.id = schedule.comment WHERE schedule.performer_id =$u_id AND time_end =0";
						$result2 = mysql_query($query) or die("Query failed3"); 
						// вывести  задачи
						while (list($for_date, $time_start, $postpone, $how_much, $name_of_task, $subcase_id, $comment, $plan_id, $fullname, $schedule_id, $link, $action, $description) = mysql_fetch_row($result2) ) {
							switch ($plan_id){
								case "0" : {
									$str="<div id=$schedule_id class=portlet><div class=portlet-header>Order from $fullname</div><div class=portlet-content><div class=date> $for_date </div> <a href='#' link='?u_id=$u_id&schedule_id=$schedule_id&type=show_dialog'  type=order>$comment </a></div></div>";
									echo $str;
									break;
								}
								case "5" : {
									$str='<div id=' . $schedule_id . ' class="portlet">
									<div class="portlet-header">' . $fullname . '</div>
									<div class="portlet-content"><div class=date>' . $for_date . '</div><a href="#" link="?group=' . $comment . '" type=test>
									' . $description . '</a></div></div>';
									echo $str;
									break;
								}
								case "4" : {
									$str='<div id=' . $schedule_id . ' class="portlet">
									<div class="portlet-header">' . $fullname . '</div>
									<div class="portlet-content"><div class=date>' . $for_date . '</div><a href="#" link="' . $link . '' . $u_id . '&schedule_id=' . $schedule_id . '" type=math>
									' . $action . '</a></div></div>';
									echo $str;
									break;
								}
								default : {
									$str="<div id=$schedule_id class=portlet><div class=portlet-header>$name_of_task</div><div class=portlet-content><div class=date> $for_date </div><div class=inf> <a href='#' link='?u_id=$u_id&schedule_id=$schedule_id&subcase_id=$subcase_id&how_much=$how_much&plan_id=$plan_id'  type=hbook> Выполнить $how_much задач</a> $comment </div></div> </div>";
									echo $str;
									break;
								}
							}
						}
					?>
                </div>
				<div id="tb1_div_2" hidden class="column">
				
				</div>
			</div>
