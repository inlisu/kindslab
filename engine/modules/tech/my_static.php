<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/modules/tech/includes/karatinit.php';
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script type="text/javascript" src="engine/skins/calendar.js"></script>
<link rel="stylesheet" type="text/css" href="engine/skins/default.css?v=2">
<link rel="stylesheet" type="text/css" href="engine/skins/jquery-ui.css?v=2">
<link rel="stylesheet" type="text/css" media="all" href="engine/skins/calendar-blue.css" title="win2k-cold-1">
<link rel="stylesheet" type="text/css" href="engine/skins/chosen/chosen.css">
<style>
	#name_tb2{font-size: 25pt;}
	#time_b{font-size: 25pt;}
	[shrift]{font-size: 12pt;}
	[shrift2]{font-size: 10pt;}
	.tb6_function_on{color: green;}
	.tb6_function_off{color: red;}
	.rate_1{background : #00FF00;}
	.percent{background : #00FF00;}
    .column {float: left; padding-bottom: 100px; }
    .portlet { margin: 0 1em 1em 0; }
    .portlet-header { margin: 0.3em; padding-bottom: 1px; padding-left: 0.2em; }
    .portlet-header .ui-icon {float: right;}
    .portlet-content { padding: 0.4em; }
    .ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
    .ui-sortable-placeholder * { visibility: hidden; } 
	#time_b {align: right;}
</style>
<?php
    if ($is_logged) {
        $u_id=$member_id['user_id'];
        $u_group=$member_id['user_group'];
        $sql='';
		
    ?>
    <script type="text/javascript" language="javascript">
        $(document).ready(ready_1);
        function ready_1(){
			daily();
			schedule_tab();
			tb1_fadein();
			var tb2_is_open = 0;
			var start_time_timeout = 0;
			var tb3_complete_plans_array = [];
			var this_schedule_id = 0;
            $('#tabs-1').on('click', ".tb1_a", function(){
				var link_ = $(this).attr("link");
				var usr_id = <?php echo ($u_id); ?>;
				var schedule1 = $(this).attr("schedule");
				var subcase_id = $(this).attr("subcase_id");
				var plan_id = $(this).attr("planfor");
				var type = $(this).attr("type");
				var name_for_tb2 = $('[schedulefor='+schedule1+']').attr('name_for_tb2');
				var checker = new XMLHttpRequest();
				checker.open('GET',"/engine/modules/tech/check_if_performing.php?user_id="+usr_id+"&schedule_id="+schedule1, true);
				checker.send(null);
				checker.onreadystatechange = function() {
					if (checker.readyState == 4) {
						if(checker.status == 200) {
							if (checker.responseText == 'Access allowed'){
								switch(type) {
									case "math": {
										var prog="/engine/ajax/math.php";
										var xmlhttp_math = new XMLHttpRequest();
										xmlhttp_math.open('GET', 'engine/modules/tech/time_start.php?sch_id='+schedule1, true);
										xmlhttp_math.send(null);
										schedule=schedule1;
										break;
									}
									case "hbook": {
										var prog="/engine/ajax/hbook.php";
										var xmlhttp_hbook = new XMLHttpRequest();
										xmlhttp_hbook.open('GET', 'engine/modules/tech/time_start.php?sch_id='+schedule1, true);
										xmlhttp_hbook.send(null);
										schedule=plan_id+"&subcase_id="+subcase_id+"&schedule_id="+schedule1;
										break;
									}
									case "order": {
										var prog="/engine/ajax/order.php";
										var xmlhttp_order = new XMLHttpRequest();
										xmlhttp_order.open('GET', 'engine/modules/tech/time_start.php?sch_id='+schedule1, true);
										xmlhttp_order.send(null);
										schedule=schedule1;
										break;
									}
									case "test": {
										var prog="/engine/ajax/test_testing.php";
										break;
									}
								}
								var xmlhttp = new XMLHttpRequest();
								xmlhttp.open('GET', prog+link_+schedule, true);
								xmlhttp.send(null);
								xmlhttp.onreadystatechange = function() {
									if (xmlhttp.readyState == 4) {
										if(xmlhttp.status == 200) {
											$("#tb2").click();
											$("#name_tb2").html(name_for_tb2);
											$("#for_doing").html(xmlhttp.responseText);
											timecounter_start(schedule);
										}
									}
								};
							}
							else{
								schedule1 = checker.responseText;
								type = $('[schedulefor='+schedule1+']').attr("type");
								link_ = $('[schedulefor='+schedule1+']').attr("link");
								subcase_id = $('[schedulefor='+schedule1+']').attr("subcase_id");
								plan_id = $('[schedulefor='+schedule1+']').attr("planfor");
								name_for_tb2 = $('[schedulefor='+schedule1+']').attr('name_for_tb2');
								alert('Закончите предыдущее задание!');
								switch(type){
									case "math": {
										var prog="/engine/ajax/math.php";
										break;
										schedule=schedule1;
									}
									case "hbook": {
										var prog="/engine/ajax/hbook.php";
										schedule=plan_id+"&subcase_id="+subcase_id+"&schedule_id="+schedule1;
										break;
									}
									case "order": {
										var prog="/engine/ajax/order.php";
										break;
										schedule=schedule1;
									}
									case "test": {
										var prog="/engine/ajax/test_testing.php";
										break;
									}
								}
								var xmlhttp = new XMLHttpRequest();
								xmlhttp.open('GET', prog+link_+schedule, true);
								xmlhttp.send(null);
								xmlhttp.onreadystatechange = function() {
									if (xmlhttp.readyState == 4) {
										if(xmlhttp.status == 200) {
											$("#tb2").click();
											$("#name_tb2").text(name_for_tb2);
											$("#for_doing").html(xmlhttp.responseText);
											timecounter_start(schedule);
										}
									}
								};
							}
						}
					}
				};
			});
			$("#tb1_choose_confimer").click(function () {
				var usr_id = $('#tb1_users').val();
				str="?user_id=" + usr_id;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/shedule_tab.php'+str, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							$("#tb1_hidden_div").html(xmlhttp.responseText);
						}
					}
				}
				xmlhttp.send(null);
				$('#tb1_hidden_div').dialog();
			});
			$('#tb3').click(function () {
				var usr_gr = <?php echo ($u_group); ?>;
				if (usr_gr !== 6){
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/request_table.php', false);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#request_table").html(xmlhttp.responseText);
							}
						}
					}
					xmlhttp.send(null);
				}
			});
			$('#tb1').click(function () {
				schedule_tab();
				//check_daily();
			});
			$('#tb8').click(function () {
				var usr_gr = <?php echo ($u_group); ?>;
				if (usr_gr !== 6){
					$("#adminpanel").fadeIn();
				}
			});
			$("#choose_confimer").click(function () {
				str="?user_id=" + $('#choose_users').val();
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/results_tab.php'+str, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							//alert(xmlhttp.responseText);
							$("#kid_results").html(xmlhttp.responseText);
							$(".tb3_checkbox").fadeIn();
						}
					}
				}
				xmlhttp.send(null);
			});
			$("#hidden_tb7_order_check_button").click(function () {
				var id = $("#hidden_tb7_order_check_users").val();
				var date = $("#hidden_tb7_order_check_date").val();
				if(date == ''){
					date = 'now';
				}
				var str="?id="+id+"&date="+date;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/order_and_hbook_check.php'+str, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							//alert(xmlhttp.responseText);
							$("#hidden_tb7_order_check_insert").html(xmlhttp.responseText);
						}
					}
				}
				xmlhttp.send(null);
			});
			$("#end_plan").click(function () {
				make_array_from_checked();
				var plans_ids = tb3_complete_plans_array.join(":");
				str="?plans_ids=" + plans_ids;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/plan_complete.php'+str, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							$("#tb3_confimer").fadeIn("slow",function(){ $("#tb3_confimer").fadeOut(4000); });
						}
					}
				}
				xmlhttp.send(null);
			});
			$("#tb8_send").click(function () {
				var usr_id = <?php echo ($u_id); ?>;
				var age = $('#tb8_age').val();
				var name = $('#tb8_name').val();
				var author = $('#tb8_author').val();
				var year = $('#tb8_year').val();
				var lang_id = $('#tb8_language').val();
				var pages = $('#tb8_pages').val();
				var exercises = $('#tb8_exercises').val();
				var link = $('#tb8_link').val();
				if (link == ''){
					link = 'отсутствует';
				}
				if(age !== '' & name !== '' & exercises !== '' & lang_id !== ''){
					str="?usr_id="+usr_id+"&age="+age+"&name="+name+"&author="+author+"&year="+year+"&lang_id="+lang_id+"&pages="+pages+"&exercises="+exercises+"&link="+link;
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/handbook_insert.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$('#tb8_age').val('');
								$('#tb8_name').val('');
								$('#tb8_author').val('');
								$('#tb8_year').val('');
								$('#tb8_language').val('');
								$('#tb8_pages').val('');
								$('#tb8_exercises').val('');
								$('#tb8_link').val('');
								$("#tb8_confimer").fadeIn("slow",function(){ $("#tb8_confimer").fadeOut(4000); });
							}
						}
					}
					xmlhttp.send(null);
				}
				else{
					alert('Заполните все поля!');
				}
			});
			$("#tb6_send").click(function () {
				var usr_id = <?php echo ($u_id); ?>;
				var task_id = $('#tb6_select').val();
				var perday = $('#tb6_perday').val();
				var planned = $('#tb6_planned').val();
				if (planned == ''){
					planned = $("#tb6_select option:selected").attr('name');
				}
				var performer_id = $('#tb6_users').val();
				var dead_line = $('#tb6_date1').val();
				if (dead_line !== '' & task_id !== '' & perday !== '' & performer_id !== ''){
					str="?usr_id="+usr_id+"&task_id="+task_id+"&per_day="+perday+"&performer_id="+performer_id+"&dead_line="+dead_line+"&planned="+planned;
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/plan_insert.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#tb6_confimer").fadeIn("slow",function(){ $("#tb6_confimer").fadeOut(4000); });
							}
						}
					}
					xmlhttp.send(null);
				}
				else{
					alert('Заполните все поля!');
				}
				
			});
			$("#tb7_hbook_check").click(function () {
				var usr_gr = <?php echo ($u_group); ?>;
				var usr_id = <?php echo ($u_id); ?>;
				if (usr_gr !== 6){
					$("#hidden_tb7_order_check").fadeOut();
					$("#hidden_tb7_results_check").fadeOut();
					$("#hidden_tb7_hbook_check").fadeIn();
				}
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/check_performing_tasks.php?u_id='+usr_id, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							$("#hidden_tb7_hbook_check_table").html(xmlhttp.responseText);
						}
					}
				}
				xmlhttp.send(null);
			});
			$("#tb7_order_check").click(function () {
				var usr_gr = <?php echo ($u_group); ?>;
				if (usr_gr !== 6){
					$("#hidden_tb7_order_check").fadeIn();
					$("#hidden_tb7_results_check").fadeOut();
					$("#hidden_tb7_hbook_check").fadeOut();
				}
			});
			$("#tb7_results_check").click(function () {
				$("#hidden_tb7_order_check").fadeOut();
				$("#hidden_tb7_results_check").fadeIn();
				$("#hidden_tb7_hbook_check").fadeOut();
				var usr_id = <?php echo ($u_id); ?>;
				var usr_gr = <?php echo ($u_group); ?>;
				if (usr_gr == 6){
					str="?user_id=" + usr_id;
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/results_tab.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#kid_results").html(xmlhttp.responseText);
							}
						}
					}
					xmlhttp.send(null);
				}
				else{
					$("#admins_results_chooser").fadeIn();
				}
			});
            $('#hidden_tb7_hbook_check').on('click', "a", function(){
				//var u_id = <?php echo ($u_id); ?>;
				//var task_date=$("#f_date_c").val();
				//var day_date;
				//var month_date;
				//var year_date;
				//var hour_date;
				//var minute_date;
				//var math_choise = $("#choise").val();
				//var task_choise = $("#choise_1").val();
				//if ($("#f_date_c").val() == ''){
				//	task_date = new Date();
				//	day_date = task_date.getDate();
				//	year_date = task_date.getFullYear();
				//	month_date = task_date.getMonth() + 1;
				//	month_date = '0' + month_date;
				//	hour_date = task_date.getHours();
				//	minute_date = task_date.getMinutes();
				//	task_date = year_date+'-'+month_date+'-'+day_date+' '+hour_date+':'+minute_date;
				//}
				//var answers_array_right = [];
				//var answers_array_wrong = [];
                //var link_ = $(this).attr("link") + "&date=" + task_date + "&u_id=" + u_id;
                //var prog="/engine/ajax/check_tasks.php";
                //var xmlhttp = new XMLHttpRequest();
                //xmlhttp.open('GET', prog+link_, true);
                //xmlhttp.send(null);
                //xmlhttp.onreadystatechange = function() {
                //    if (xmlhttp.readyState == 4) {
                //        if(xmlhttp.status == 200) {
                //            $("#for_check").html(xmlhttp.responseText);
                //            // нужно предупреждать - Идет запись ... Записано.
                //        }
                //    }
                //};
				//$("#conf_but").click(function () {
				//	var internal_array = [];
				//	var internal_array_length = $(".right:checked").length;
				//	for (var i = 0; i < internal_array_length; i++){
				//		internal_array[i] = $(".right:checked").eq(i).attr("name");
				//	}
				//	answers_array_right = internal_array;
				//	internal_array = [];
				//	internal_array_length = $(".wrong:checked").length;
				//	for (var i = 0; i < internal_array_length; i++){
				//		internal_array[i] = $(".wrong:checked").eq(i).attr("name");
				//	}
				//	answers_array_wrong = internal_array;
				//	var right_to_update = answers_array_right.join(":");
				//	var wrong_to_update = answers_array_wrong.join(":");
				//	if (right_to_update == ''){
				//		right_to_update = 'x';
				//	}
				//	if (wrong_to_update == ''){
				//		wrong_to_update = 'x';
				//	}
				//	str="?wrong=" + wrong_to_update + "&right=" + right_to_update;
				//	var xmlhttp = new XMLHttpRequest();
				//	xmlhttp.open('GET', 'engine/modules/tech/results_update.php'+str, true);
				//	xmlhttp.send(null);
				//	xmlhttp.onreadystatechange = function() {
				//		if (xmlhttp.readyState == 4) {
				//			if(xmlhttp.status == 200) {
				//				$("#alert3").fadeIn("slow",function(){ $("#alert3").fadeOut(4000); });
				//			}
				//		}
				//	};
				//});
            });
			$('#tb6_select').change(function () {
				$('#tb6_exercises').text($("#tb6_select option:selected").attr('name'));
			});
			$('#tb8_daily_add_plan_names').change(function () {
				$('#tb8_daily_add_plan_times').text($("#tb8_daily_add_plan_names option:selected").attr('name'));
			});
			$('#tb8_daily_add_send').click(function () {
				var name = $('#tb8_daily_add_name').val();
				var times = $('#tb8_daily_add_times').val();
				times = times.replace(/-/g,":");
				var time = $("#tb8_daily_add_perform_time").val();
				if (time == ''){
					time = 10;
				}
				if (name !== '' & times !== ''){
					str="?name="+name+'&times='+times+'&rec_time='+time;
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/daily_schedule_insert.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#tb8_daily_add_confimer").fadeIn("slow",function(){ $("#tb8_daily_add_confimer").fadeOut(4000); });
								$('#tb8_daily_add_name').val('');
								$('#tb8_daily_add_times').val('');
							}
						}
					}
					xmlhttp.send(null);
				}
				else{
					alert('Заполните все поля:3');
				}
			});
			$('#tb8_daily_add_plan_send').click(function () {
				var user_id = <?php echo ($u_id); ?>;
				var daily_id = $('#tb8_daily_add_plan_names').val();
				var performer_id = $('#tb8_daily_add_plan_users').val();
				if (daily_id !== '' | performer_id !== ''){
					str="?daily_id="+daily_id+'&performer_id='+performer_id+'&user_id='+user_id;
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/daily_schedule_plan_insert.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#tb8_daily_add_plan_confimer").fadeIn("slow",function(){ $("#tb8_daily_add_plan_confimer").fadeOut(4000); });
								$('#tb8_daily_add_plan_names').val('');
								$('#tb8_daily_add_plan_users').val('');
							}
						}
					}
					xmlhttp.send(null);
				}
				else{
					alert('Заполните все поля:3');
				}
			});
			$('#tb8_readbook_add_send').click(function () {
				var name  = $('#tb8_readbook_add_name').val();
				var author = $('#tb8_readbook_add_author').val();
				var pages = $('#tb8_readbook_add_pages').val()*1;
				var age   = $('#tb8_readbook_add_age').val()*1;
				var year  = $('#tb8_readbook_add_year').val()*1;
				str="?name="+name+'&author='+author+'&pages='+pages+'&age='+age+'&year='+year;
				if (name !== ''){
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/readbook_add.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#tb8_readbook_add_confimer").fadeIn("slow",function(){
									$("#tb8_readbook_add_confimer").fadeOut(4000);
								});
								//alert(xmlhttp.responseText);
								$('#tb8_readbook_add_name').val('');
								$('#tb8_readbook_add_autor').val('');
								$('#tb8_readbook_add_pages').val('');
								$('#tb8_readbook_add_age').val('');
								$('#tb8_readbook_add_year').val('');
							}
						}
					}
					xmlhttp.send(null);
				}
				else{
					alert('Заполните название книги.');
				}
			});
			$("#tabs").tabs();
			$('#tb4').click(function () {
				var u_id = <?php echo ($u_id); ?>;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/current_book.php?u_id='+u_id, false);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							$("#current_book_div").html(xmlhttp.responseText);
						}
					}
				}
				xmlhttp.send(null);
				var book = $("#current_book").text();
				if (book == ''){
					$("#tb4_books").fadeIn();
				}
			});
			$('#tb6').click(function () {
				var usr_gr = <?php echo ($u_group); ?>;
				if (usr_gr !== 6){
					$("#tb6_funcition_switcher_table").fadeIn();
				}
			});			
			$("#tb4_select_button").click(function () {
				var age = $("#tb4_select_age").val();
				var u_id = <?php echo ($u_id); ?>;
				if (age !== 'Выберите возраст'){
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/readbook_show.php?age='+age+'&u_id='+u_id, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#tb4_table").html(xmlhttp.responseText);
								//alert(xmlhttp.responseText);
							}
						}
					}
					xmlhttp.send(null);
				}
				else{
					alert('Выберите возраст');
				}
			});
			$(".tb6_switcher").click(function () {
				var condition_switch_id = $(this).val();
				var condition_switch_state = $(this).attr('state');
				var str = 'condition='+condition_switch_state+'&id='+condition_switch_id;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/switch_condition.php?'+str, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							if (condition_switch_state == '0'){
								$("[switcher="+condition_switch_id+"]").text('Выключено');
								$("[switcher="+condition_switch_id+"]").attr('class', 'tb6_function_off');
								$("[value="+condition_switch_id+"]").attr('state', '1');
							}
							else{
								$("[switcher="+condition_switch_id+"]").text('Включено');
								$("[switcher="+condition_switch_id+"]").attr('class', 'tb6_function_on');
								$("[value="+condition_switch_id+"]").attr('state', '0');
							}
						}
					}
				}
				xmlhttp.send(null);
			});
            $("#ins_task").click(function () {
                var multipleValues = $("#users1").val() || [];
                var users=multipleValues.join(":");
                var task_txt=$("#task_txt").val();
                var task_date=$("#f_date_c_1").val();
				var choise_test_group = $("#choise_test_group").val();
				var time_to_perform = $("#time_txt").val();
				if(time_to_perform == ''){
					time_to_perform = '00:10';
				}
				var case_action;
				var day_date;
				var month_date;
				var year_date;
				var hour_date;
				var minute_date;
				var math_choise = $("#choise").val();
				var task_choise = $("#choise_1").val();
				if (task_date == ''){
					task_date = new Date();
					day_date = task_date.getDate();
					year_date = task_date.getFullYear();
					month_date = task_date.getMonth() + 1;
					month_date = '0' + month_date;
					hour_date = task_date.getHours();
					minute_date = task_date.getMinutes();
					task_date = year_date+'-'+month_date+'-'+day_date+' '+hour_date+':'+minute_date;
				}
				if (users !== '' & task_txt !== ''  & math_choise == ''){
					case_action = 0;
					str="?users=" + users + "&case_action=" + case_action + "&task_txt=" + $("#task_txt").val() + "&task_date=" + task_date + "&submiter_id=" + <?php echo ($u_id); ?> + "&recommended_time="+time_to_perform;
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/task_to_sheduler.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#task_txt").val("");
								//alert(xmlhttp.responseText);
								//$("#alert4").fadeIn("slow",function(){ $("#alert4").fadeOut(4000); });
							}
						}
					};
					xmlhttp.send(null);
				}
				if (users !== '' & math_choise !== '' & task_txt == ''){
					case_action = 4;
					str="?users=" + users + "&case_action=" + case_action + "&task_txt=" + math_choise + "&task_date=" + task_date + "&submiter_id=" + <?php echo ($u_id); ?> + "&recommended_time=00:10";
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open('GET', 'engine/modules/tech/task_to_sheduler.php'+str, true);
					xmlhttp.onreadystatechange = function() {
						if (xmlhttp.readyState == 4) {
							if(xmlhttp.status == 200) {
								$("#choise").val("");
								//$("#alert4").fadeIn("slow",function(){ $("#alert4").fadeOut(4000); });
							}
						}
					};
					xmlhttp.send(null);
				}
				//if (users !== '' & choise_test_group !== '' & math_choise == '' & task_txt == ''){
				//	case_action = 5;
				//	str="?users=" + users + "&case_action=" + case_action + "&task_txt=" + choise_test_group + "&task_date=" + task_date + "&submiter_id=" + <?php echo ($u_id); ?>;
				//	var xmlhttp = new XMLHttpRequest();
				//	xmlhttp.open('GET', 'engine/modules/tech/task_to_sheduler.php'+str, true);
				//	xmlhttp.onreadystatechange = function() {
				//		if (xmlhttp.readyState == 4) {
				//			if(xmlhttp.status == 200) {
				//				$("#choise_test_group").val("");
				//				$("#alert4").fadeIn("slow",function(){ $("#alert4").fadeOut(4000); });
				//			}
				//		}
				//	};
				//	xmlhttp.send(null);
				//}
				if (math_choise == '' & task_txt == '' & choise_test_group == '' | users == ''){
					alert('Выберите пользовател(я/ей) и задание (поручение/математика)');
				}
			});
			$("#lessons_adder").click(function () {
				str="?u_id=" + <?php echo ($u_id); ?>;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/my_static_lessons_adder.php'+str, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							$("#alert2").fadeIn("slow",function(){ $("#alert2").fadeOut(4000); });
						}
					}
				}
				xmlhttp.send(null);
			});
			function make_array_from_checked() {
				var internal_array = [];
				var internal_array_length = $(".tb3_checkbox:checked").length;
				for (var i = 0; i < internal_array_length; i++){
					internal_array[i] = $("input:checked").eq(i).val();
				}
				tb3_complete_plans_array = internal_array; //добавление во внешний массив выбранных checkbox
			}
			function tb1_fadein(){
				var usr_gr = <?php echo ($u_group); ?>;
				if (usr_gr !== 6){
					$("#tb1_hidden_admins_chooser").fadeIn();
				}
			}
			function schedule_tab(){
				var u_id = <?php echo ($u_id); ?>;
				var u_group = <?php echo ($u_group); ?>;
				str="?u_id="+u_id+"&u_group="+u_group;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/schedule_tab.php'+str, false);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							$("#tb1_div_1").html(xmlhttp.responseText);
						}
					}
				}
				xmlhttp.send(null);
			}
			function check_daily(){
				str="?u_id=" + <?php echo ($u_id); ?>;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/check_if_have_daily.php'+str, false);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							if(xmlhttp.responseText == 'Access denied'){
								//alert(xmlhttp.responseText);
								$(".tb1_a").fadeOut('slow');
								$("[hider=daily]").fadeIn('slow');
							}
						}
					}
				}
				xmlhttp.send(null);
			}
			function daily(){
				var usr_id = <?php echo ($u_id); ?>;
				str="?u_id=" + usr_id;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/daily_insertion.php'+str, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
						}
					}
				}
				xmlhttp.send(null);
				start_time_timeout_daily = setTimeout(daily, 600000);
			}
			function start_time() {
				planned_second = planned_second - 1;
				if(planned_second < 0){
					planned_minute = planned_minute - 1;
					planned_second = planned_second + 60;
				}
				if(planned_minute < 0){
					planned_hour = planned_hour - 1;
					planned_minute = planned_minute + 60;
				}
				if(planned_hour < 0){
					$("#time_in_tb2").text('00:00:00');
				}
				else{
					if (planned_hour < 10){
						text_hour = "0" + planned_hour;
					}
					else{
						text_hour = planned_hour;
					}
					if (planned_minute < 10){
						text_minute = "0" + planned_minute;
					}
					else{
						text_minute = planned_minute;
					}
					if (planned_second < 10){
						text_second = "0" + planned_second;
					}
					else{
						text_second = planned_second;
					}
					$("#time_in_tb2").text(text_hour + ":" + text_minute + ":" + text_second);
					start_time_timeout = setTimeout(start_time, 1000);
				}
			}
			function timecounter_start(local_schedule){
				clearTimeout(start_time_timeout);
				str="?schedule_id="+local_schedule;
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('GET', 'engine/modules/tech/query_for_timer.php'+str, false);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if(xmlhttp.status == 200) {
							planned_time = xmlhttp.responseText;
						}
					}
				}
				xmlhttp.send(null);
				if(planned_time == 'late'){
					$("#time_in_tb2").text('00:00:00');
				}
				else{
					if(planned_time > 60){
						planned_hour = Math.floor(planned_time / 60);
						planned_minute = planned_time - planned_hour * 60;
					}
					else{
						planned_minute = planned_time;
						planned_hour = 0;
					}
					planned_second = 0;
					start_time();
				}
			}
        }
    </script>
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1" id=tb1>Расписание</a></li>
            <li><a href="#tabs-2" id=tb2>Выполнение задач</a></li>
            <li><a href="#tabs-5" id=tb5>Поставить задачу</a></li>
            <li><a href="#tabs-7" id=tb7>Проверка</a></li>
			<li><a href="#tabs-8" id=tb8>Админпанель</a></li>
			<li><a href="#tabs-3" id=tb3>Заявки</a></li>
			<li><a href="#tabs-6" id=tb6>Управление</a></li>
			<li><a href="#tabs-4" id=tb4>Книги</a></li>
        </ul>
        <div id="tabs-1">
            <div style="float: left;">
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
				<div>
					<span hidden id = 'otlog'>Отложено!</span>
				</div>
				<div id="tb1_hidden_calendar" hidden title='Отложить задание'>
					<input type="text" name="newdate" id="f_date_c_tb1" size="20"  class="edit bk" value="">
					<img src="engine/skins/images/img.gif"  align="absmiddle" id="f_trigger_c_tb1" style="cursor: pointer; border: 0" title="Выбор даты с помощью календаря"/>
					<script type="text/javascript">
						Calendar.setup({
								inputField     :    "f_date_c_tb1",     // id of the input field
								ifFormat       :    "%Y-%m-%d %H:%M",      // format of the input field
								button         :    "f_trigger_c_tb1",  // trigger for the calendar (button ID)
								align          :    "Br",           // alignment 
								timeFormat     :    "24",
								showsTime      :    false,
								singleClick    :    true
						});
					</script><br>
					<span>Выберите дату, на которую хотите отложить задание.</span><br>
					<button id = 'postpone_button'>Отложить</button>
				</div>
				<div id="tb1_hidden_div" title='Расписание' hidden>
				</div>
				
                <div id="tb1_div_1">
                </div>
				
				<div id="tb1_div_2" hidden >
				</div>
            </div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> <br><br><br><br>
        </div>
        <div id="tabs-2">
			<div>
				<br><br>
				<span id="name_tb2"></span>
				<b id="time_b">      <span id="time_in_tb2"></span></b>
				<br>
				<br>
			</div>
			<br>
			<div id="for_doing">
			</div>
        </div>
        <div id="tabs-3">
			<span id='request_table'>
			</span>
        </div>
        <div id="tabs-4">
			<div id='tb4_books' hidden>
				<select id='tb4_select_age'>
					<option>Выберите возраст</option>
					<?php
						$query='SELECT age FROM readbooks GROUP BY age';
						$result=mysql_query($query) or die (':(');
						while (list($id) = mysql_fetch_row($result) ) {
							echo("<option value='$id'>$id</option>");
						}
					?>
				</select>  
				<button id='tb4_select_button'>Показать</button>
				
				<br>
				<br>
				<br>
			</div>
			<div id='current_book_div'>
			</div>
			<br><br><br>
			<table id='tb4_table'>
			</table>
			
		</div>
        <div id="tabs-5">
            <div id="set_task">
                <table>
					<tr>
                        <td>
							<button id=ins_task>Включить в расписание</button>&nbsp;задачу:&nbsp;
						</td>
						<td>
							<textarea id=task_txt></textarea>
							<br>
							<select id="choise">
								<option></option>
								<?php
										$query = "SELECT math.id, math.action FROM math ORDER BY math.id ASC";
										$result2 = mysql_query($query) or die("Query failed3");
										while (list($id, $action) = mysql_fetch_row($result2) ) {
											$str='<option value=' . $id . '>' . $action . '</option>';
											echo $str;
										}
								?>
							</select>
							<!-- <br>
							<select id="choise_test_group">
								<option></option>
								<?php
									//$query = "SELECT id, short_description FROM test_groups ORDER BY id ASC";
									//$result2 = mysql_query($query) or die("Query failed3");
									//// вывести список users кому можно ставить задачи
									//while (list($id, $short_description) = mysql_fetch_row($result2) ) {
									//	$str='<option class=choise value=' . $id . '>' . $short_description . '</option>';
									//	echo $str;
									//}
								?>
							</select> -->
						</td>
						<td>
							&nbsp;&nbsp;кому:&nbsp;
							<SELECT  id=users1 multiple="multiple">
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
						</td>
						<td>
							&nbsp;на дату:&nbsp;<input type="text" name="newdate" id="f_date_c_1" size="20"  class="edit bk" value="">
							<img src="engine/skins/images/img.gif"  align="absmiddle" id="f_trigger_c_1" style="cursor: pointer; border: 0" title="Выбор даты с помощью календаря"/>
							<script type="text/javascript">
								Calendar.setup({
										inputField     :    "f_date_c_1",     // id of the input field
										ifFormat       :    "%Y-%m-%d %H:%M",      // format of the input field
										button         :    "f_trigger_c_1",  // trigger for the calendar (button ID)
										align          :    "Br",           // alignment 
										timeFormat     :    "24",
										showsTime      :    false,
										singleClick    :    true
								});
							</script>
						</td>
						<td>
							  Время на выполнение(чч:мм) <input type='text' id='time_txt'></input>
						</td>
						<td>
							<br>
							<span id=alert4 hidden=true style="color:#ff0000"><b>  Задание добавлено.</b></span>
						</td>
					</tr>
				</table>
				<hr NOSHADE WIDTH="100%" SIZE="20">
				<table>
					<tr>
						<td>
							<button id = 'lessons_adder'>Добавить</button>
						</td>
						<td>
							
							<span id = "adder_2">
								Добавляет все задания на сегодняшний день.
							</span>
							<span id=alert2 hidden=true style="color:#ff0000"><b>Задания добавлены.</b></span>
						</td>
					</tr>
				</table>
            </div>
        </div>
        <div id="tabs-6">
			<table id='tb6_funcition_switcher_table' hidden>
				<tr><td shrift='tb6_table'>Функция</td><td>              </td><td shrift='tb6_table'>Состояние       </td><td>              </td><td shrift='tb6_table'>Переключатель состояния</td></tr>
				<tr><td> </td><td> </td><td> </td><td> </td><td> </td></tr>
				<?php
					
					
					$query = "SELECT * FROM management";
					$result = mysql_query($query) or die ("Query Falied :)");
					while (list($id, $function, $condition) = mysql_fetch_row($result) ) {
						if ($condition == '0'){
							echo("<tr><td shrift2>$function</td><td>              </td><td><b class='tb6_function_on' shrift='tb6_table' switcher='$id'>Включено</b></td><td>              </td><td><button class='tb6_switcher' state='$condition' value='$id'>Переключить</button></td></tr>");
						}
						else{
							echo("<tr><td shrift2>$function</td><td>              </td><td><b class='tb6_function_off' shrift='tb6_table' switcher='$id'>Выключено</b></td><td>              </td><td><button class='tb6_switcher' state='$condition' value='$id'>Переключить</button></td></tr>");
						}
					}
				?>
			</table>
		</div>
		<div id="tabs-7">
			<button style="font: 12pt sans-serif;" id="tb7_hbook_check">Проверить текущее выполнение заданий</button>
			<button style="font: 12pt sans-serif;" id="tb7_order_check">Проверить order+hbook</button>  
			<button style="font: 12pt sans-serif;" id="tb7_results_check">Проверить успеваемость</button>  
			
			<div id="hidden_tb7_hbook_check" hidden>
				<table id="hidden_tb7_hbook_check_table">
					
				</table>
			</div>
			<div id="hidden_tb7_results_check" hidden>
				<div id = "admins_results_chooser" hidden>
					<SELECT  id="choose_users">
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
					<button id = "choose_confimer">Посмотреть</button>
					<button id = "end_plan">Завершить</button>
					<span id = "tb3_confimer" hidden style="color:#ff0000"><b>Задания помечены как завершённые.</b></span>
				</div>
				<table id = "kid_results">
					
				</table>
            </div>
			<div id="hidden_tb7_order_check" hidden>
				<SELECT  id="hidden_tb7_order_check_users">
					<?php
						$query = "SELECT user_id, fullname FROM dle_users WHERE family_id = (SELECT family_id FROM dle_users WHERE dle_users.user_id = $u_id ) ORDER BY user_id ASC";
						$result2 = mysql_query($query) or die("Query failed :3");
						while (list($user__id, $fullname) = mysql_fetch_row($result2) ) {
							$str="<option value='$user__id'>$fullname</option>";
							echo $str;
						}
					?>
				</SELECT>
				&nbsp;&nbsp;
				<input type="text" name="newdate" id="hidden_tb7_order_check_date" size="20"  class="edit bk" value="">
				<img src="engine/skins/images/img.gif"  align="absmiddle" id="hidden_tb7_order_check_date_1" style="cursor: pointer; border: 0" title="Выбор даты с помощью календаря"/>
				<script type="text/javascript">
					Calendar.setup({
							inputField     :    "hidden_tb7_order_check_date",     // id of the input field
							ifFormat       :    "%Y-%m-%d %H:%M",      // format of the input field
							button         :    "hidden_tb7_order_check_date_1",  // trigger for the calendar (button ID)
							align          :    "Br",           // alignment 
							timeFormat     :    "24",
							showsTime      :    false,
							singleClick    :    true
					});
				</script>
				<button style="font: 12pt sans-serif;" id="hidden_tb7_order_check_button">Просмотр</button>
				<br>
				<div id="hidden_tb7_order_check_insert">
					
				</div>
            </div>
		</div>
		<div id="tabs-8">
			<div id = "adminpanel" hidden>
				<div name='add_task_to_plan'>
					<span style="font: 15pt sans-serif;">Добавить задание в план   </span>     <span id = "tb6_confimer" hidden style="color:#ff0000"><b>Задание добавлено в план.</b></span>
					<br><br><br>
					<table>
						<tr>
							<td>Название</td>
							<td></td>
							<td>Дневная норма</td>
							<td></td>
							<td>Кому</td>
							<td></td>
							<td>Крайний срок</td>
							<td></td>
							<td>Общее количество  </td>
							<td></td>
							<td>Запланированное количество</td>
						</tr>
						<tr>
							<td>
								<SELECT  id='tb6_select'>
									<option name=''></option>
									<?php
										$query = "SELECT tasks.id, tasks.name, handbooks.exercises FROM tasks LEFT JOIN handbooks ON handbooks.id = tasks.subcase_id";
										$result = mysql_query($query) or die("Query failed3");
										// вывести список users кому можно ставить задачи
										while (list($tasks_id, $name, $amount) = mysql_fetch_row($result) ) {
											$str='<option name = ' . $amount . ' value=' . $tasks_id . '>' . $name . '</option>';
											echo $str;
										}
									?>
								</SELECT>
							</td>
							<td></td>
							<td><input type = "text" id = "tb6_perday"></td>
							<td></td>
							<td>
								<SELECT  id="tb6_users">
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
							</td>
							<td></td>
							<td>
								<input type="text" name="newdate" id="tb6_date1" size="20"  class="edit bk" value="">
								<img src="engine/skins/images/img.gif"  align="absmiddle" id="tb6_date2" style="cursor: pointer; border: 0" title="Выбор даты с помощью календаря"/>
								<script type="text/javascript">
									Calendar.setup({
											inputField     :    "tb6_date1",     // id of the input field
											ifFormat       :    "%Y-%m-%d %H:%M",      // format of the input field
											button         :    "tb6_date2",  // trigger for the calendar (button ID)
											align          :    "Br",           // alignment 
											timeFormat     :    "24",
											showsTime      :    false,
											singleClick    :    true
									});
								</script>
							</td>
							<td></td>
							<td><span id = "tb6_exercises"></span></td>
							<td></td>
							<td><input type = "text" id = "tb6_planned"></td>
							<td></td>
							<td><button id = "tb6_send">Добавить</button></td>
						</tr>
					</table>
				</div>
				<br><br>
				<div name='add_handbook'>
					<span style="font: 15pt sans-serif;">Добавить учебник</span>     <span id = "tb8_confimer" hidden style="color:#ff0000"><b>Учебник добавлен.</b></span>
					<br><br><br>
					<table>
						<tr>
							<td>Возраст</td>
							<td>Название</td>
							<td>Автор</td>
							<td>Год </td>
							<td>Язык</td>
							<td>Страниц</td>
							<td>Упражнений</td>
							<td>Ссылка</td>
						</tr>
						<tr>
							<td><input type = "text" id = "tb8_age"></td>
							<td><input type = "text" id = "tb8_name"></td>
							<td><input type = "text" id = "tb8_author"></td>
							<td><input type = "text" id = "tb8_year"></td>
							<td>
								<select id = "tb8_language">
									<option value = "1">Русский</option>
									<option value = "2">Украинский</option>
									<option value = "3">Английский</option>
								</select>
							</td>
							<td><input type = "text" id = "tb8_pages"></td>
							<td><input type = "text" id = "tb8_exercises"></td>
							<td><input type = "text" id = "tb8_link"></td>
							<td>    <button id = "tb8_send">Добавить</button></td>
						</tr>
					</table>
				</div>
				<br><br>
				<div name='add_daily_schedule'>
					<span style="font: 15pt sans-serif;">Добавить ежедневное задание</span>     <span id = "tb8_daily_add_confimer" hidden style="color:#ff0000"><b>Ежедневное задание добавлено</b></span>
					<br><br><br>
					<table>
						<tr>
							<td>Название</td>
							<td>Время (вводить через запятую - 13:23,15:41,12:23)</td>
							<td>Время на выполнение(чч:мм)</td>
						</tr>
						<tr>
							<td><input type = "text" id = "tb8_daily_add_name"></td>
							<td><input size='60' type = "text" id = "tb8_daily_add_times"></td>
							<td><input type = "text" id = "tb8_daily_add_perform_time"></td>
							<td>    <button id = "tb8_daily_add_send">Добавить</button></td>
						</tr>
					</table>
				</div>
				<br><br>
				<div name='add_daily_in_plan'>
					<span style="font: 15pt sans-serif;">Добавить ежедневное задание в план</span>     <span id = "tb8_daily_add_plan_confimer" hidden style="color:#ff0000"><b>Ежедневное задание добавлено в план</b></span>
					<br><br><br>
					<table>
						<tr>
							<td>Название     </td>
							<td>Кому     </td>
							<td>Время                                          </td>
						</tr>
						<tr>
							<td>
								<SELECT  id='tb8_daily_add_plan_names'>
									<option name=''></option>
									<?php
										$query = "SELECT id, name, times FROM schedule_daily";
										$result = mysql_query($query) or die("Query failed3");
										// вывести список users кому можно ставить задачи
										while (list($id, $name, $times) = mysql_fetch_row($result) ) {
											$str="<option name='$times' value='$id'>$name</option>";
											echo $str;
										}
									?>
								</SELECT>
							</td>
							<td>
								<SELECT  id="tb8_daily_add_plan_users">
									<?php
										$query = "SELECT user_id, fullname FROM dle_users WHERE family_id = (SELECT family_id FROM dle_users WHERE dle_users.user_id = $u_id ) ORDER BY user_id ASC";
										$result2 = mysql_query($query) or die("Query failed3");
										// вывести список users кому можно ставить задачи
										while (list($user__id, $fullname) = mysql_fetch_row($result2) ) {
											$str="<option value='$user__id'>$fullname</option>";
											echo $str;
										}
									?>
								</SELECT>
							</td>
							<td><span id = "tb8_daily_add_plan_times"></span></td>
							<td>    <button id = "tb8_daily_add_plan_send">Добавить</button></td>
						</tr>
					</table>
				</div>
				<br><br>
				<div name='add_readbook'>
					<span style="font: 15pt sans-serif;">Добавить книгу</span>     <span id = "tb8_readbook_add_confimer" hidden style="color:#ff0000"><b>Книга добавлена</b></span>
					<br><br><br>
					<table>
						<tr>
							<td>Название</td>
							<td>   </td>
							<td>Автор</td>
							<td>   </td>
							<td>Возраст</td>
							<td>   </td>
							<td>Количество страниц</td>
							<td>   </td>
							<td>Год</td>
						</tr>
						<tr>
							<td><input type = "text" size='60' id = "tb8_readbook_add_name"></td>
							<td>   </td>
							<td><input type = "text" size='40' id = "tb8_readbook_add_author"></td>
							<td>   </td>
							<td><input type = "text" id = "tb8_readbook_add_age"></td>
							<td>   </td>
							<td><input type = "text" id = "tb8_readbook_add_pages"></td>
							<td>   </td>
							<td><input type = "text" id = "tb8_readbook_add_year"></td>
							<td>   </td>
							<td><button id = "tb8_readbook_add_send">Добавить</button></td>
						</tr>
					</table>
				</div>
				<br><br>
				<!--<div name='add_project'>
					<span style="font: 15pt sans-serif;">Добавить проект</span>     <span id = "tb8_readbook_add_confimer" hidden style="color:#ff0000"><b>Проект добавлен</b></span>
					<br><br><br>
					<table>
						<tr>
							<td>Название</td>
							<td>   </td>
							<td>Описание</td>
							<td>   </td>
							<td>Deadline</td>
						</tr>
						<tr><td>   </td><td>   </td><td>   </td><td>   </td><td>   </td></tr>
						<tr><td>   </td><td>   </td><td>   </td><td>   </td><td>   </td></tr>
						<tr>
							<td><input type = "text" size='60' id = "tb8_project_add_name"></td>
							<td>   </td>
							<td><textarea rows="10" cols="50"></textarea></td>
							<td>   </td>
							<td><input type = "text" id = "tb8_readbook_add_age"></td>
							<td>   </td>
							<td><button id = "tb8_project_add_send">Добавить</button></td>
						</tr>
					</table>
				</div>-->
			</div>
        </div>
	</div>
<?php }?>
