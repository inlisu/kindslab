﻿$(function(){
	u_name=$("#login-btn").html();
//	$("#datepicker").datepicker({dateFormat:'yy-mm-dd'});
	var n;
	user_id=1000;
	money();
	iii=1;
});
function go_to_tasks(act,sched_br) {
		if (u_name!="login"){
			$.get("engine/modules/tech/any_open_task.php?u_name="+u_name, function(data){
			var arrg = data.split('*');
				if (arrg[0] === null || arrg[0]===undefined || arrg[0]==""){
					$.get("engine/modules/tech/shedule_tab.php?u_name="+u_name+'&act='+act+'&sched_br='+sched_br, function(data1){
					$("#tb1_div_1").html(data1);
							$(".trash4").click(function(){ 
			if (confirm('Удалить задачу??')) {
				$(this).parent().parent().parent().remove();
				$.get("engine/modules/tech/del_task.php?task_id=" +$(this).attr('task_id'), function(data){
				alert(data);
				});
			}
		});
					});
					document.location.href = "#all_tasks";
				}
				else {
						alert("Выполняется задача!: ");
						$("#current_task").html(arrg[1]);
						$("#stop_task").attr('task_id',arrg[0]);
						$("#stop_task").attr('logic_id',arrg[2]);

						document.location.href = "#do_task";
					}
			});
		}
}
function math_trainer_insert(){
/* 	u_name=$("#login-btn").html();
	if (u_name!="login"){
		$.get("engine/modules/tech/any_open_task.php?u_name="+u_name, function(data){
			var arrg = data.split('*');

				if (arrg[0] === null || arrg[0]===undefined || arrg[0]==""){	 */
				$.get("engine/modules/tech/math_trainer_options_insert.php", function(data1){
				$("#math_trainer_insert").html("data1"+data1);
				});
				document.location.href = "#math_trainer";
	/* 		}
			else {
						alert("Выполняется задача!: ");
						$("#current_task").html(arrg[1]);
						$("#stop_task").attr('task_id',arrg[0]);
						$("#stop_task").attr('logic_id',arrg[2]);
						
						document.location.href = "#do_task";
				}
		});
	} */
}
function math_trainer(link){
	u_name=$("#login-btn").html();
				assignment='';
/* 				$.post("engine/modules/tech/task_start.php",{assignment:assignment,u_name:u_name,task_id:155,time:4,sched_id:0}, function(data2){

					}); */
	$.get("engine/modules/tech/math.php"+link+u_name, function(data1){
		$("#math_trainer_insert").html(data1);
						document.location.href = "#math_trainer";
	});
}   
function stop_task() {
if ($("#stop_task").attr('logic_id')==2 && $("#result").val()=="")
	{
	alert("Result!!!");
	return;
	}
	if ($("#stop_task").attr('logic_id')==4 && $("#clock").html()*1<=0 && !isNaN($("#clock").html())){ alert (!isNaN($("#clock").html()));

	$.get("engine/modules/tech/add_5.php?user_id="+user_id+"&add="+$("#logic4").attr('total_hm'), function(data){
				alert (!isNaN($("#clock").html()));
	});
	}
	$.post("engine/modules/tech/task_stop.php",{u_name:u_name,task_id:$("#stop_task").attr('task_id'),result:$("#result").val(),qw:0,all:0,con:0,mood:0}, function(data){
	var arrg = data.split(',');
	var result_=arrg[0];
	switch (result_) {
		case "Act_close":
//		alert("Задача завершена");
		$("#current_task").html("");
		window.clearTimeout(n);
		history.back();
		break;
		case "No_open_act":
		alert("Нет открытых задач");
		$("#current_task").html("");									
		history.back();
		break;
		case "Another_exist":
				alert("Сейчас выполняется другая задача");
		$("#current_task").html(arrg[2]);
		$("#stop_task").attr('task_id',arrg[1]);
		$("#stop_task").attr('logic_id',arrg[3]);
		document.location.href = "#do_task";
		break;
		}
	});
}; 
function start_task(task_id,name,logic_id) {document.location.href = "#do_task";

	if ($("#current_task").html()==""){		
		$.get("engine/modules/tech/check_task.php?u_name='"+u_name+"'&task_id="+task_id, function(data){
		var arrg = data.split(',');
		var result_=arrg[0]; 			
		var id_task=arrg[2];
		assignment="";
		if (result_=="Violation" && logic_id==4){
			result_	="New_act_create";		
		}
		/* 		if (result_=="Violation" ){
		if (confirm ("У вас есть замечание без оплаты, но вы можете выполнить эту задачу за -10.")){
			result_	="New_act_create";		
			$.get("engine/modules/tech/add_5.php?user_id="+$("#login-btn").attr('user_id')+"&add=-10", function(data){	
			});
		}} */
		switch (result_) {
			case "Already_exist":
			alert("Не закончена предыдущая задача");
			logic_id=arrg[3];
			name=arrg[1];
			$("#clock").html("Продолжена работа");
			$("#current_task").html(name);
			$("#stop_task").attr('task_id',id_task);
			$("#stop_task").attr('logic_id',logic_id);
			document.location.href = "#do_task";
			break;
			case "New_act_create":

				switch (logic_id) {
					case "1": 
					$.post("engine/modules/tech/task_start.php",{assignment:assignment,u_name:u_name,task_id:task_id,time:40,sched_id:0}, function(data){
						$("#clock").html(40+':00');
						Timer();
						$("#current_task").html(name);
						$("#stop_task").attr('task_id',task_id);
						$("#stop_task").attr('logic_id',logic_id);
						$("#result").val(""); 
						document.location.href = "#do_task";
						$("#result").focus();
						});
					break;
					case "2":


  						var assignment = prompt('Describe assignment, please:');

						var time=40;
						$.post("engine/modules/tech/task_start.php",{assignment:assignment,u_name:u_name,task_id:task_id,time:time,sched_id:0}, function(data){
						$("#clock").html(time+':00');
						Timer();
						$("#current_task").html(name);
						
						$("#stop_task").attr('logic_id',logic_id);
						$("#result").val("");
						$("#stop_task").attr('task_id',task_id);
						document.location.href = "#do_task";

						$("#result").focus();
						});
					break;
					case "3":
					//var assignment = prompt('Describe assignment, please:');
						
						var time=40;
					$.post("engine/modules/tech/task_start.php",{assignment:assignment,u_name:u_name,task_id:task_id,time:time,sched_id:0}, function(data){
						$("#clock").html(time+':00');
						Timer();
						$("#current_task").html(name);
						$("#stop_task").attr('logic_id',logic_id);
						$("#result").val("");
						
						$("#stop_task").attr('task_id',task_id);
						document.location.href = "#do_task";

						$(".lbl_rslt").after("<a  class='ui-btn ui-corner-all ui-btn-inline' onclick=ins_data_to_db('"+u_name+"',"+task_id+");> Done</a>" );
						$("#result").focus();
						$("#result").keyup(function(event){ //перхват нажатия "Enter" 
							if (event.keyCode == 13) {
								ins_data_to_db($('#result').val());
								$('#result').val("")
							}
						});
					});
					break;
					case "4":					case 4:
					case '4':		
						if (add_=$(".cred").html()*1){
						var time=40;
						$("#clock").html(Math.floor(add_*0.7));
						plus_(2500); 					
						$.post("engine/modules/tech/task_start.php",{assignment:assignment,u_name:u_name,task_id:task_id,time:time,sched_id:0}, function(data){
						$("#current_task").html(name);
						$("#stop_task").attr('logic_id',logic_id);		
						$("#stop_task").attr('task_id',task_id);
						$("#stop_task").attr('log_action_id',data);
						$("#result").val("");	
						$("#logic4").attr('style','visibility: visible');
						$("#logic4").attr('total_hm',add_);
						document.location.href = "#do_task";
						$("#hm_").focus();
						$("#hm_").keyup(function(event){ //перхват нажатия "Enter"
						hm=$('#hm_').val()
						if (event.keyCode==13 && hm!="") {
						$("#clock").html($("#clock").html()-$('#hm_').val());	
							ins_data_to_db($('#hm_').val(),$("#stop_task").attr('log_action_id'));
							$('#hm_').val("")
							}});
						});				}		
					break;
					case "5":
					break;
					case "6":
					break;
					case "7":
					break;
			}

			break;
			case "Another_exist":
			alert("Не закончена предыдущая задача");
			$("#clock").html("Продолжена работа");
			$("#current_task").html(arrg[1]);
			$("#stop_task").attr('task_id',arrg[2]);
			
			document.location.href = "#do_task";
			break;
			case "Violation":
			alert("Есть замечания или не принятые работы");
			kid_viol($("#login-btn").attr('user_id'));
					    
			break;
			}
		});
	}
	else document.location.href = "#do_task";
}
function change_task_list() {
	$.get("engine/modules/tech/show_tasks_list.php?u_name="+u_name, function(data){
		$("#chtl").html(data);
		document.location.href = "#change_task_list";
	});
}		
function task_add_rem(task_id,state) {
	if (confirm('Are you sure you want to save this into the database?')) {
		$.get("engine/modules/tech/task_add_rem.php?u_name="+u_name+"&task_id=" +task_id+"&state=" +state, function(data){
			alert(data);
		});
    } 
	else {
		alert("No changes");
	}
}		
function add_new_task() {
	task_name=$("#task_name").val();
	activity_type=0;
	id=0+1*$("#my_targets_list option:selected").attr('id').substring(4);
	$('.custom1:checked').each(function(i,elem) {activity_type=activity_type+$(this).attr("id")*1;});

	if (task_name.length>3 && activity_type!=0){
		if (confirm('Are you sure you want to save this task into the database?')) {
			$.get("engine/modules/tech/add_new_task.php?u_name="+u_name+"&task_name=" +task_name+"&activity_type=" +activity_type+"&id=" +id, function(data){
				alert(data);	
				change_task_list();
			});
		}
	}
}
function show_kids(){
	$.get("engine/modules/tech/show_kids.php?u_name="+u_name, function(data){
		$("#show_kids").html(data);
	});
}
function kid_click(u_name){
	$.get("engine/modules/tech/today_tasks.php?u_name="+u_name, function(data){
		$("#today_tasks_d").html(data);
		$("#today_tasks_d1").attr('onclick','sum_time_today("'+u_name+'",0);');
		document.location.href = "#today_tasks";
	});
}
function kid_click1(user_id){
	if (add_=prompt('Describe assignment, please:',10)*1){
	$.get("engine/modules/tech/add_5.php?user_id="+user_id+"&add="+add_, function(data){
		alert(data);
	});
	}
}
function kid_viol(user_id){
	$(".audioDemo").trigger('pause');
	$.get("engine/modules/tech/show_viol_list.php?user_id="+user_id, function(data){
		$("#p_dialog").html(data);
				$(".trash6").click(function(){
			if (confirm('Оплатить??')) {
				$(this).parent().parent().parent().remove();
				$.get("engine/modules/tech/ask_pay_bill.php?viol_id=" +$(this).attr('viol_id')+"&u_name="+u_name, function(data){
				$("#p_dialog").html(data);
				});
			}
});
//		alert(data);
});
$.mobile.changePage( "#myDialog", { role: "dialog" } );
}
function sum_time_today(u_name, shift){
	$.get("engine/modules/tech/sum_time_today.php?u_name="+u_name+'&shift='+shift, function(data){
		$("#sum_time_today_d").html(data);
		$("#d_back").attr('onclick','sum_time_today("'+u_name+'",1);');
//		$("#sum_day_forward").val($("#sum_day_forward").val()+1);
//		$("#sum_day_back").val($("#sum_day_back").val()-1);
		document.location.href = "#sum_time_today";
	});
}
function Timer() {
	var clock=$("#clock").html().split(':');
	if (clock[1]<=0){
		clock[1]='59';
		clock[0]=clock[0]-1;
	}
	else {
		clock[1]=clock[1]-1;
	}
	$("#clock").html(clock[0]+':'+clock[1]);
    n = setTimeout(arguments.callee, 1000);
}
function plus_(timout) {
	var clock=$("#clock").html()*1;
	if (clock<=0){
		return
	}
	else {
		clock=clock+1;
	
	$("#clock").html(clock);
    n = setTimeout(arguments.callee, 11000);}
}
function show_rules_list(ctrl,u_name) {
	$.get("engine/modules/tech/show_rule_list.php?u_name="+u_name+"&ctrl="+ctrl, function(data){
		$("#rules").html(data);
				$(".trash3").click(function(){ 
			if (confirm('Удалить правило???')) {
				$(this).parent().parent().parent().remove();
				$.get("engine/modules/tech/del_rule.php?rule_id=" +$(this).attr('rule_id'), function(data){
				alert(data);
				});
			}
		});
		document.location.href = "#rule_list";
	});
}
function add_new_rule() {
	rule_name=$("#rule_name").val();
	$("#rule_name").val("");
	if (rule_name.length>10){
		if (confirm('Are you sure you want to save this rule into the database?')) {
			$.get("engine/modules/tech/add_new_rule.php?u_name="+u_name+"&rule_name=" +rule_name, function(data){
				show_rules_list();
			});
		} 
	}
}
function money() {
	$.get("engine/modules/tech/get_money.php?u_name="+u_name, function(data){	
		var arrg = data.split(',');
		var deb=arrg[0];
		var cred=arrg[1]; 
		var hm=arrg[2];
		$("#login-btn").attr('user_id',arrg[3]);
		user_id=arrg[3];
		$(".deb").html(deb);
		$(".cred").html(cred);
		if ($(".hm").html()<hm){
			$(".audioDemo").trigger('load');
			$(".audioDemo").trigger('play');
			}
		$(".hm").html(hm);
		show_kids();
	});
	n = setTimeout(arguments.callee, 10000);
}
function tranz(rule_id) {
if (confirm('Are you sure you want to set violation to this rule into the database?')) {
	$.get("engine/modules/tech/violation.php?u_name="+u_name+"&rule_id=" +rule_id, function(data){
	alert(data);
		
	});
}
}
function min_lost(user_id) {

	$.get("engine/modules/tech/min_lost.php?user_id="+u_name+"&user_id=" +user_id, function(data){
	alert(data);
		
	});

}
function show_viol_list(ctrl) {
	$.get("engine/modules/tech/show_viol_list.php?user_id="+$("#login-btn").attr('user_id')+"&ctrl="+ctrl, function(data){
		$("#viol").html(data);
		$(".audioDemo").trigger('pause');
		document.location.href = "#viol_list";
		$(".trash6").click(function(){ 
			if (confirm('Оплатить??')) {
				$(this).parent().parent().parent().remove();
				$.get("engine/modules/tech/ask_pay_bill.php?viol_id=" +$(this).attr('viol_id'), function(data){
				alert(data);
				});
		}
});
});
}
function complaint(violation_id_) {
	var compl_ = prompt('Не более 150 символов');
	if (compl_){
		$.post("engine/modules/tech/complaint.php",{compl:compl_,violation_id:violation_id_ }, function(data,status){alert(data,status);});
	}
}
function tranz4(viol_id) {
if (confirm('Are you sure you want to pay this bill?')) {
		$.get("engine/modules/tech/ask_pay_bill.php?u_name="+u_name+"&viol_id=" +viol_id, function(data){	
		alert(data);
		});
    }
	else {
		alert("No changes");
	}
}
function ins_data_to_db(ex,log_id){
$.get("engine/modules/tech/ins_data_to_db.php?u_name='"+u_name+"'&log_id=" +log_id+"&ex='" +ex+"'", function(data){
$("#alert_hm").html(data);
$("#alert_hm").fadeIn(3000,function(){$("#alert_hm").fadeOut(3000);});
});
}
function tranz1(rule_id) {
if (confirm('Are you sure you want to pay this indulgence?')) {
		$.get("engine/modules/tech/pay_indulgence.php?rule_id=" +rule_id, function(data){
		alert(data);
		});
}
	else {
		alert("No changes");
	}
}
function new_task(){
		$.get("engine/modules/tech/my_targets.php?user_id=" +$("#login-btn").attr('user_id'), function(data){
		$("#my_targets_list").html(data);
		document.location.href = "#add_task";
		});
}
function show_targets_list(user_id){
		$.get("engine/modules/tech/show_targets_list.php?user_id=" +user_id, function(data){
		$("#my_targets").html(data);
		$(".trash2").click(function(){ 
			if (confirm('Удалить цель??')) {
				$(this).parent().parent().parent().remove();
				$.get("engine/modules/tech/del_target.php?target_id=" +$(this).attr('target_id'), function(data){
				alert(data);
				});
			
			
			}
		});
		document.location.href = "#all_targets";
		});
}
function show_targets_list1(){
		$.get("engine/modules/tech/show_targets_list.php?user_id=" +$("#login-btn").attr('user_id'), function(data){
		$("#my_targets").html(data);
		$(".trash2").click(function(){ 
			if (confirm('Удалить цель??')) {
				$(this).parent().parent().parent().remove();
				$.get("engine/modules/tech/del_target.php?target_id=" +$(this).attr('target_id'), function(data){
				alert(data);
				});
			
			
			}
		});
		document.location.href = "#all_targets";
		});
}
function show_target_descr(id){
		$.get("engine/modules/tech/show_target_descr.php?id=" +id, function(data){
		$("#p_dialog").html(data);
//		document.location.href = "#myDialog";
		});
}
function new_target(){
		$.get("engine/modules/tech/my_handbooks.php?user_id=" +$("#login-btn").attr('user_id'), function(data){
		$("#handbooks").html(data);
		document.location.href = "#add_target";
		});
}
function add_target() {
		id=$("#handbooks option:selected").attr('id');
 		$.post("engine/modules/tech/add_target.php",{user_id:$("#login-btn").attr('user_id'),name:$("#target_name").val(),desc:$("#target_descr").val(),deadline:$("#datepicker").val(),id:id.substring(4)}, function(data,status){alert(data,status);});
		u_id=$("#login-btn").attr('user_id');
		alert (u_id);
		show_targets_list(u_id);
}
function show_resources_list(){
		$.get("engine/modules/tech/show_resources_list.php?user_id=" +$("#login-btn").attr('user_id'), function(data){
		$("#my_resource").html(data);
		document.location.href = "#all_resource";
		});
}
function new_resource(){
		$.get("engine/modules/tech/my_handbooks.php?user_id=" +$("#login-btn").attr('user_id'), function(data){
		$("#handbooks").html(data);
		document.location.href = "#add_target";
		});
}
function show_act(){
		$.get("engine/modules/tech/show_act.php?user_id=" +$("#login-btn").attr('user_id'), function(data){
		$("#my_resource").html(data);
		document.location.href = "#all_resource";
		});
}
function show_schedule(sched_id,user_id){
	parent_mod=1;
	if (user_id==0) {
		user_id=$("#login-btn").attr('user_id');
		parent_mod=0;
	}
	if (sched_id!=0){ // если 0 то нужно показать список расписаний
	
		$.get("engine/modules/tech/show_schedule.php?user_id=" +user_id + '&sched_id=' + sched_id + '&parent_mod=' + parent_mod, function(data){
			$("#my_sched").html(data);
			$.get("engine/modules/tech/doing_sched.php?user_id=" +user_id+ '&sched_id=' + sched_id, function(data){	
				asa=data.split("---");		
					done='';
					$(".cgreen").html("0");
					asa.forEach(function(id_res, index) {					
					awa=id_res.split(",");
					id=awa[0];
					result=awa[1];
					time_start=awa[2];
					duration=awa[3];
					done="#done"+id;

					if (id>0) {
						p="#sch" + id;
						r="#hm" + id;
						b="#ti" + id;
						g="#dl" + id;
						du="#du" + id;						
						$(p).css("background-color", "green");
						if (result==1) $(r).css("background-color", "green");
						if (result==0) $(r).css("background-color", "black");
						if (result==-1) $(r).css("background-color", "red");
						
						$(p).attr("task","finish");

 //						if ($(g).html()!='00:00'){
						$(b).html(time_start);												
						$(du).html(duration);												
//						} 
//alert ($(b).html());
						$(".cgreen").html($(".cgreen").html()*1+$(done).html()*1);
					}
					else {
						p="#sch" + Math.abs(id);
						$(p).attr("task","doing");
						$(p).css("background-color", "blue");
					}
				});
			});
			document.location.href = "#sched";
		});	
	}	
	else {
		$.get("engine/modules/tech/show_my_schedules.php?user_id=" +user_id+'&parent_mod=' + parent_mod, function(data){
			$("#my_sched").html(data);
			document.location.href = "#sched";
				$(".trash5").click(function(){ 
			if (confirm('Удалить расписание???')) {
				$(this).parent().parent().parent().remove();
				$.get("engine/modules/tech/del_schedule.php?sched_id=" +$(this).attr('sched_id'), function(data){
				alert(data);
				});
			}
		});			
	});
	}
	}
function  sched_breack(){
		go_to_tasks(63,1);
}
function  sch_task_start(id,task_id,logic_id, done, late, abandon){
		p="#sch" + id;
		if ($(p).attr("task")=="wait" ) {
			if (confirm('Начинаем выполнение?'))	{
			assignment="";
				switch (logic_id) {						
					case 1: 
$.get("engine/modules/tech/check_task.php?u_name='"+u_name+"'&task_id="+task_id, function(data){
		var arrg = data.split(',');
		var result_=arrg[0]; 
		var name=arrg[1];		
		var id_task=arrg[2];
		assignment="";
		switch (result_) {
		case "Another_exist":
		case  "Already_exist": 
		alert("Не закончена предыдущая задача");
		$("#clock").html("00:00");
		$("#current_task").html(arrg[1]);
		$("#stop_task").attr('task_id',arrg[2]);
		//	document.location.href = "#do_task";
		break;
		case  "New_act_create":
					$.post("engine/modules/tech/task_start.php",{assignment:assignment,u_name:u_name,task_id:task_id,time:40,sched_id:id}, function(data){
						if(data*1>=1){
						$(p).attr("task","doing")
						$(p).css("background-color", "blue");
						}
					});
		break;
			case "Violation":
			alert("Есть замечания или не принятые работы");
			kid_viol($("#login-btn").attr('user_id'));
					    
			break;
		}
		});
					break;
					case 2:
  						var assignment = prompt('Describe assignment, please:');
						var time=40;
						$.post("engine/modules/tech/task_start.php",{assignment:assignment,u_name:u_name,task_id:task_id,time:time,sched_id:id}, function(data){
						$("#clock").html(time+':00');
						Timer();
						$("#current_task").html(name);
						
						$("#stop_task").attr('logic_id',logic_id);
						$("#result").val("");
						$("#stop_task").attr('task_id',task_id);
						document.location.href = "#do_task";

						$("#result").focus();
						});
					break;
					case 3:
					//var assignment = prompt('Describe assignment, please:');
						
						var time=40;
						$.post("engine/modules/tech/task_start.php",{assignment:assignment,u_name:u_name,task_id:task_id,time:time,sched_id:id}, function(data){
						$("#clock").html(time+':00');
						Timer();
						$("#current_task").html(name);
						$("#stop_task").attr('logic_id',logic_id);
						$("#result").val("");
						$("#stop_task").attr('task_id',task_id);
						document.location.href = "#do_task";
						$(".lbl_rslt").after("<a  class='ui-btn ui-corner-all ui-btn-inline' onclick=ins_data_to_db('"+u_name+"',"+task_id+");> Done</a>" );
						$("#result").focus();
						$("input").keyup(function(event){ //перхват нажатия "Enter" в любом поле ввода
				if (event.keyCode == 13) {
					ins_data_to_db($('#result').val());
				}});
						});
					
					
					
					
					
					break;
					case "4":
					break;
					case "5":
					break;
					case "6":
					break;
					case "7":
					break;
			}

}}
		if ($(p).attr("task")=="finish") {
								alert ("Задача уже выполнена");

		}
		if ($(p).attr("task")=="doing") { // Остановить задачу
				$("#sch_task_stop").attr('onclick','');
				$("#sch_task_stop").attr('onclick','stop_sched_task("'+u_name+'",'+task_id+','+done+');');
		$.mobile.changePage( "#myDialog1", { role: "dialog" } );
}} 
function stop_sched_task(u_name,task_id,done){
				all=$("#fl1").val();
				qw=$("#fl2").val();
				con=$("#fl3").val();
				mood=$("#fl4").val();	

				if (all==0){ $(p).css("background-color", "black");
				$(p).attr("task","wait");
				wert="Задача отложена";
				}
				else {
					$(p).css("background-color", "green");
				$(p).attr("task","finish");
				wert="Задача завершена";
				}
				
				$(".cgreen").html($(".cgreen").html()*1+done);
				if ($("#stop_task").attr('logic_id')==2 && $("#result").val()==""){
				alert("Result!!!");
				return;
				}

			$.post("engine/modules/tech/task_stop.php",{u_name:u_name,task_id:task_id,result:"",qw:qw,all:all,con:con,mood:mood }, function(data){			
				var arrg = data.split(',');
				var result_=arrg[0];
				switch (result_) {
				case "Act_close":
//				alert(wert);
				break;
				case "No_open_act":
				alert("Нет открытых задач");
				break;
				case "Another_exist":
				alert("Сейчас выполняется другая задача");
				break;
				}
			});
								
		

}
function  edit_schedule(sched_id) {
	$.get("engine/modules/tech/sched_edit.php?sched_id="+sched_id+"&user_id=" +$("#login-btn").attr('user_id'), function(data){
		splited=data.split('123321231');
		ssd="<div>Имя <input  id='sched_name' size='35'></div><div>Описание:<input  id='sched_descr' size='100'></div>"+splited[0]
		$("#my_sched").html(ssd);
		$( "#sortable" ).sortable();
//		$( "#sortable" ).disableSelection();
			$(".trash").click(function(){
			$(this).parent().remove();
			});
		$( ".task_name" ).click(function(){
			$(this).after(splited[1]);	
			$(this).hide();
			$(this).attr('id','current');
			$(".sel_task").change(function(){
//			alert ($(".sel_task option:selected").attr('id'));
				$("#current").show();
				$("#current").val($(".sel_task option:selected").val());
//				$("#current").attr('id','');
				$("#current").attr('id',$(".sel_task option:selected").attr('id'));
//			alert ($("#current").attr('id'));	
				$(this).remove();
				});	
			});
			document.location.href = "#sched";

			});
			$('#prerv').after('<a id=save  onclick="sched_save();"class="ui-btn ui-corner-all ui-btn-inline" style="z-index:12" >Записать</a>');

}
 function  sched_save() {
	a='';
	$.each( $('.str_sched'), function( i, value ) {
		a=a+"'"+$('.str_sched').eq(i).children().eq(0).attr('id')+"'"+',';
		$.each($('.str_sched').eq(i).children(".inp_fild"), function( j, valuje ) {
			a=a+"'"+$('.str_sched').eq(i).children(".inp_fild").eq(j).val()+"'"+',';
		});
		a=a+"'"+i+"'" +")!!(";
		});

		$.post("engine/modules/tech/save_sched.php",{data:a,name:$("#sched_name").val(),description:$("#sched_descr").val(),user_id
		:$("#login-btn").attr('user_id')}, function(data2){
		alert(data2);
		});
}
 function  del_schedule(sched_id,user_id){
	 	$.get("engine/modules/tech/del_schedule.php?sched_id="+sched_id+"&user_id=" +user_id, function(data){
		alert(data);
	 });
}
 function  add_row(){
			$(".str_sched").last().after("<li class='ui-state-default str_sched ui-sortable-handle'><input id=344 class='task_name inp_fild' size=25><input class='inp_fild' size=40><input  class='inp_fild' size=3><input  class='inp_fild'   size=3><input  class='inp_fild'   size=2><input class='inp_fild'  size=3><input  class='inp_fild'   size=3><input  class='inp_fild'   size=3><span  class=' trash ui-icon ui-icon-trash'></span></li>");
			$(".trash").click(function(){
			$(this).parent().remove();
					$( "#sortable" ).sortable();
			});
}
 function  check(sched_id, result){
	 	$.get("engine/modules/tech/save_check_result.php?sched_id="+sched_id+"&result=" +result, function(data){

		r='#hm'+sched_id;
		if (result==1) $(r).css("background-color", "green");
		if (result==0) $(r).css("background-color", "black");
		if (result==-1) $(r).css("background-color", "red");
		alert(data);
});
}
 function  ex_log(log_id, u_name){
	 	$.get("engine/modules/tech/ex_log.php?log_id="+log_id, function(data){
		$("#p_dialog").html(data);
		$.mobile.changePage( "#myDialog", { role: "dialog" } );
		});
	}
 function  shult(){
	 $.get("engine/modules/tech/add_5.php?user_id="+$("#login-btn").attr('user_id')+"&add=-2", function(data){});
	 	$.get("engine/modules/tech/shult.php?user_id=" +$("#login-btn").attr('user_id'), function(data){
		$("#p_dialog").html(data);
		$.mobile.changePage( "#myDialog", { role: "dialog" } );
		var Numbers = new Array();
		for (var i=1;i<=25;i++){Numbers[i] = i;	}
		for (var i=1;i<=25;i++){
		var randomer = rand(1,25);
		var tmp = Numbers[i];
		Numbers[i] = Numbers[randomer];
		Numbers[randomer] = tmp;		}
		var i3=1;
		for (var i=1;i<=5;i++){
			for (var i2=1;i2<=5;i2++){
			document.getElementById('t_'+i+'_'+i2).innerHTML = Numbers[i3];
			$('#t_'+i+'_'+i2).attr('class', 'ee'+Numbers[i3] );
			if (Math.random()>0.5) rnd_clr="#ffcc00"; else rnd_clr="#00ffcc";
			document.getElementById('t_'+i+'_'+i2).style.backgroundColor = rnd_clr;
			i3++;
			}
		}
		iii=1;err=0;mon=1;
		$.post("engine/modules/tech/task_start_1.php",{assignment:'',user_id:$("#login-btn").attr('user_id'),task_id:4,time:40,sched_id:0}, function(data1){});
		$('#current').html(iii);$('body').unbind();
				$("body").keyup(function(event){ //перхват нажатия 
				bg_clr=$('.ee'+iii).css('background-color');
				if (event.keyCode == 37) {
					if (bg_clr == "rgb(0, 255, 204)") {beep() ; $('#current').html(++iii);}
					else err=err+1;
				}
				if (event.keyCode == 39) {
					if (bg_clr == "rgb(255, 204, 0)") {beep(); $('#current').html(++iii);}
					else err=err+1;
				}
				if (iii>25){
				 document.location.href = "#main_page";
				 $.post("engine/modules/tech/task_stop_1.php",{user_id:$("#login-btn").attr('user_id'),task_id:4,result:err}, function(data){ 
				 
				 if (err<2 & data>10){
					if (data<85){mon=Math.floor(3/(err+1));}
					if (data<75){mon=Math.floor(5/(err+1));}
					if (data<55){mon=Math.floor(8/(err+1));}
					if (data<35){mon=Math.floor(10/(err+1));}
					if ($("#hiddd").attr('chfree')!='1') mon=0;
					mon=0; //Чтобы не зарабатывать!
					$.get("engine/modules/tech/add_5.php?user_id="+$("#login-btn").attr('user_id')+"&add="+mon, function(data){alert(mon+' '+ err);mon=0;$('body').unbind();});
				 beep() ;beep() ;beep() ;beep() ;beep() ;beep() ;beep() ;beep() ;beep() ;}
				;})
				alert("Шульте не добавляет баллы");
				}
				});
			});
 }
 function show_desc(id){
	 dd1='des'+id;
	 alert(dd1);-
	 alert($("#descr_target").attr(dd1));
	 }
	function rand (min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	function beep() {
    var snd = new Audio("data:audio/wav;base64,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qJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");  
    snd.play();
}
