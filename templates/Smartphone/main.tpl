<!DOCTYPE html>
<html>
<head>
{headers}
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/templates/Smartphone/css/engine.css" rel="stylesheet">
<link href="/templates/Smartphone/css/style.css" rel="stylesheet">
<script src="/templates/Smartphone/js/libs.js" type="text/javascript"></script>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<script src="/templates/Smartphone/js/jquery-1.11.1.min.js"></script>
<link  href="/templates/Smartphone/css/jquery-ui.css">
<script src="/templates/Smartphone/js/jquery-ui.js"></script>
<audio class="audioDemo" controls preload="none" style="display:none;">
<source src="/engine/modules/tech/be.mp3" type="audio/mpeg">
<source src="audio/music.ogg" type="audio/ogg">
</audio>
<link media="screen" href="/templates/Smartphone/css/jquery.mobile-1.4.3.min.css" type="text/css" rel="stylesheet" />
<script src="/templates/Smartphone/js/jquery.mobile-1.4.3.min.js" type="application/x-javascript" charset="utf-8"></script>
<script src="/templates/Smartphone/js/script.js" type="application/x-javascript" charset="utf-8"></script>
<script src="/templates/Smartphone/js/my.js" type="application/x-javascript" charset="utf-8"></script>
<style type="text/css" media="screen">@import "{THEME}/css/style1.css";</style>	 
<!--[if lt IE 9]><script src="/templates/Smartphone/js/html5shiv.js" type="text/javascript"></script><![endif]-->
</head>
<body>
	<div data-role="page" id="main_page" data-theme="b">
	    <div data-role="header1">
			<h1></h1>
			{login}				[not-group=5]	<a onclick='kid_viol(user_id)' class="ui-btn ui-corner-all ui-btn-inline money"> Money:<span class=deb>55</span>&nbsp&nbsp&nbsp<span class=hm>99</span>&nbsp&nbsp&nbsp<span id=cred class=cred style="color:red">-66</span>&nbsp&nbsp<span class=cgreen style="color:green">0</span></a>
[group=1,2,3]
			<a onclick='show_kids1()' class="ui-btn ui-corner-all ui-btn-inline">Setings</a>
			[/group]
		</div>
<div id="sound"></div>
		<div data-role="content" >
			<ul data-role="listview" data-inset="true" data-theme="a">
				<li><a id=go_to_tasks onclick="go_to_tasks(63);">Задачи</a></li>
				<li><a href="#activities">Виды деятельности</a></li>
				<li><a onclick="change_task_list();">Изменить список задач</a></li>
				<li><a onclick="show_schedule(0,0);">Расписания</a></li>				
				<li><a onclick="show_targets_list1();">Цели</a></li>
				<li><a onclick="show_resources_list();">Ресурсы</a></li>					
				<li><a onclick="show_rules_list(0,u_name);">Список правил</a></li>
				<li><a onclick="math_trainer_insert();">Матем. тренажер</a></li>
				<li><a onclick="shult();">Таблицы Шульте</a></li>
			[group=1,2,3]
				<li><a onclick='show_kids();document.location.href = "#show_kids_list";'>Дети</a>
				<li><a onclick='show_rules_list("ctrl")'>Управление</a>
			[/group]
			</ul>
		</div> 
		<section id="content">
			{info}
			{content}
		</section>
		<div data-role="footer">
		</div>
	</div>	
	<div data-role="page" id="today_tasks" data-theme="b" >
		<div data-role="controlgroup" data-type="horizontal" >
			<a  data-rel="back"  class="ui-btn ui-corner-all ui-btn-inline" style="z-index:12">Назад!</a>
			<a href="#sum_time_today" class="ui-btn ui-corner-all ui-btn-inline" style="z-index:12" id=today_tasks_d1>SUM Time</a>
			<a class="ui-btn ui-corner-all ui-btn-inline" style="z-index:12" onclick="show_act();">Activities</a>
		</div>
		
		<div data-role="fieldcontain">
			<ul id=today_tasks_d class="ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-a" data-role="listview" data-	inset="true" data-theme="a" >
			</ul>
		</div>
		<div data-role="footer">				
		</div>
	</div>
	<div data-role="page" id="sum_time_today" data-theme="b" >
		<div data-role="header" data-type="horizontal" >
		<div data-role="controlgroup" data-type="horizontal">
			<a  data-rel="back"  data-role="button"  >Назад</a>
			<a href="#sum_day_back" data-role="button"  id=d_back>Day back</a>
			<a href="#sum_day_forward" data-role="button" id=d_forward>Day forward</a>
		</div>
		</div>		
		<div data-role="fieldcontain">
		<ul id=sum_time_today_d class="ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-a" data-role="listview" data-inset="true" data-theme="a" >
			
			</ul>
			
		</div>
		<div data-role="footer">				
				
		</div>
			
	</div>
	<div data-role="page" id="all_tasks" data-theme="b">
		<div data-role="header" >
			<h1></h1>	
			<a  data-rel="back"  class="ui-btn-left">Назад</a>
		</div>
		<div data-role="content" >	
			<ul id=tb1_div_1 class="ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-a" data-role="listview" data-inset="true" data-theme="a">
			</ul>
		</div>
		<div data-role="footer">				
		</div>
	</div>
			<div data-role="page" id="all_resource" data-theme="b">
		<div data-role="header" >
			<h1></h1>
			<a  data-rel="back"  class="ui-btn-left">Назад</a>
			<a onclick="new_resource();" class="ui-btn-right" style="position:fixed;  z-index:12">Add new resource</a>
		</div>
		<div data-role="content" >	
			<ul id=my_resource class="ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-a" data-role="listview" data-inset="true" data-theme="a">
			</ul>
		</div>
		<div data-role="footer">				
		</div>
	</div>
		<div data-role="page" id="all_targets" data-theme="b">
		<div data-role="header2" >
			<h1></h1>
			<a  data-rel="back"  class="ui-btn ui-corner-all ui-btn-inline">Назад</a>
			<a onclick="new_target();" class="ui-btn ui-corner-all ui-btn-inline">Add new target</a>
		</div>
		<div data-role="content" >	
			<ul id=my_targets class="ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-a" data-role="listview" data-inset="true" data-theme="a">
			</ul>
		</div>
		<div data-role="footer">				
		</div>
	</div>
		<div data-role="page" id="add_target" data-theme="b">
		<div data-role="header" >
			<h1></h1>	
			<a  data-rel="back"  class="ui-btn-left">Назад</a>
		</div>
		<div data-role="content" >	
			<label for="name">Target name:</label>
			<input type="text" name="name" id="target_name" />
			<label for="descr">Target description:</label>
			<textarea name="descr" id="target_descr"> </textarea>
			<p>DeadLine: <input type="text" id="datepicker"></p>
<label for="handbooks">Select handbook</label>
<select  id="handbooks">
<option></option>
<option>Slower</option>
<option>Slow</option>
<option >Medium</option>
<option>Fast</option>
<option>Faster</option>
</select>
			
			<ul data-role="listview" data-inset="true" data-theme="a">
				<li><a onclick="add_target()" >Add target</a></li>
			</ul>
		</div>
		<div data-role="footer">				
		</div>
	</div>
	
	
	
	
	<div data-role="page" id="show_kids_list" data-theme="b">
		<div data-role="header" >
			<h1></h1>	
			<a  data-rel="back"  class="ui-btn-left">Назад</a>
			<a class="ui-btn-right" onclick="show_kids();">Refresh</a>
		</div>
		<div data-role="content" >	
			<ul id=show_kids class="ui-listview ui-listview-inset ui-corner-all ui-shadow ui-group-theme-a" data-role="listview" data-inset="true" data-theme="a" >
			</ul>
		</div>
		<div data-role="footer">				
		</div>
	</div>
	<div data-role="page" id="change_task_list" data-theme="b" >
		<div data-role="header"  >
			<a  data-rel="back"  class="ui-btn-left" style="position:fixed;  z-index:12">Назад</a>
			<a onclick="new_task();" class="ui-btn-right" style="position:fixed;  z-index:12">Добавить задачу</a>
		</div>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup" id=chtl>
			</fieldset>
		</div>
		<div data-role="footer">				
		</div>
	</div>
	<div data-role="page" id="viol_list" data-theme="b" >
		<div data-role="header"  >
			<a  data-rel="back"  class="ui-btn-left" style="position:fixed;  z-index:12">Назад</a>
		</div>
		
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup" id=viol>
			</fieldset>
		</div>
		<div data-role="footer">				
		</div>
	</div>
	<div data-role="page" id="add_task" data-theme="b">
		<div data-role="header">
			<h1></h1>	
		<a  data-rel="back"  class="ui-btn-left">Назад</a>
		</div>
		<div data-role="content" >	
			<label for="name">Задача:</label>
			<input type="text" name="name" id="task_name" />
			<label >Вид деятельности:</label><table><tr><td>
			<input type='checkbox' name='checkbox-1' id='1' class='custom1'/>
			<label for='1'>Развлечение</label ></td><td>
			<input type='checkbox' name='checkbox-2' id='2' class='custom1'/>
			<label for='2'>Развитие</label ></td></tr><tr><td>
			<input type='checkbox' name='checkbox-3' id='4' class='custom1'/>
			<label for='4'>Общение</label ></td><td>
			<input type='checkbox' name='checkbox-4' id='8' class='custom1'/>
			<label for='8'>Творчество</label ></td></tr><tr><td>
			<input type='checkbox' name='checkbox-5' id='16' class='custom1'/>
			<label for='16'>Быт</label ></td><td>
			<input type='checkbox' name='checkbox-6' id='32' class='custom1'/>
			<label for='32'>Здоровье</label </td></tr></table>
			 <fieldset>
<label for="speed">Выбрать цель</label>
<select  id="my_targets_list">
<option></option>

</select>
			
			<ul data-role="listview" data-inset="true" data-theme="a">
				<li><a onclick="add_new_task()" >Добавить задачу</a></li>
			</ul>
		</div>
		<div data-role="footer">			
		</div>
	</div>	
	<div data-role="page" id="add_rule" data-theme="b">
		<div data-role="header" >
			<h1></h1>	
		<a  data-rel="back"  class="ui-btn-left">Назад</a>
		</div>
		<div data-role="content" >	
			<label for="name">Правило:</label>
			<input type="text" name="name" id="rule_name" />
			<ul data-role="listview" data-inset="true" data-theme="a">
				<li><a onclick="add_new_rule()">Добавть правило</a></li>
			</ul>
		</div>
		<div data-role="footer">			
		</div>
	</div>
	<div data-role="page" id="rule_list" data-theme="b" >
		<div data-role="header"  >
			<a  data-rel="back"  class="ui-btn-left" style="position:fixed;  z-index:12">Назад</a>
			<a href="#add_rule" class="ui-btn-right" style="position:fixed;  z-index:12">Добавить новое правило</a>
		</div>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup" id=rules>
			</fieldset>
		</div>
		<div data-role="footer">				
		</div>
	</div>
	<div data-role="page" id="math_trainer" data-theme="b" >
		<div data-role="header"  >
			<a  data-rel="back"  class="ui-btn-left" style="position:fixed;  z-index:12">Назад</a>
		</div>
		<br><br>
		<div id="math_trainer_insert" data-role="fieldcontain">
		</div>
		<div data-role="footer">				
		</div>
	</div>
	<div data-role="page" id="do_task" data-theme="b">
		<div data-role="header">
		<h1 id=current_task></h1>	
		</div>
		<div data-role="content">
		<div id=clock style="color:#0055cc; font:bold 48pt Tahoma; text-align: center "></div>
		<table><tr><td>
		<label class= 'lbl_rslt' for="result">Результат:</label></td><td>
		<input type="text" name="result" id="result"></td></tr>	<tr id=logic4 style="visibility: hidden; " ><td>
		<label class= 'lbl_rslt' for="result">Выполнено: </label></td><td>
		<input type="text" id="hm_"></td></tr>	</table>
		<span id='alert_hm' hidden style="color: red; font-size: 15pt;">Данные учтены и записаны</span>
		<ul data-role="listview" data-inset="true" data-theme="a">
			<li><a id="stop_task" onclick="stop_task()">Закончить выполнение</a></li>
		</ul>
		</div>
		<div data-role="footer">				
		</div>
	</div>
		<div data-role="page" id="activities" data-theme="b">
		<div data-role="header">
		<div data-role="controlgroup" data-type="horizontal">
			<a   data-role="button" data-rel="back" >Назад</a>
		</div>
		</div>
		<div data-role="content">
		<ul data-role="listview" data-inset="true" data-theme="a">
				<li><a onclick='go_to_tasks(1);'>Развлечение</a>
				<li><a onclick="go_to_tasks(2);">Развитие</a></li>
				<li><a onclick="go_to_tasks(4);">Общение</a></li>
				<li><a onclick="go_to_tasks(8);">Творчество</a></li>
				<li><a onclick="go_to_tasks(16);">Быт</a></li>
				<li><a onclick='go_to_tasks(32)'>Здоровье</a>
			</ul>
		</div>
		<div data-role="footer">
		</div> 
	</div>
		<div data-role="page" id="sched" data-theme="b">
		<div data-role="header">
		<div data-role="controlgroup" data-type="horizontal">
			<a href="#main_page"  class="ui-btn ui-corner-all ui-btn-inline" style="z-index:12">Назад</a>
			<a onclick='kid_viol(user_id)' class="ui-btn ui-corner-all ui-btn-inline"> Money:<span class=deb>55</span>&nbsp&nbsp&nbsp<span class=hm>99</span>&nbsp&nbsp&nbsp<span class=cred style="color:red">0</span>&nbsp&nbsp<span class=cgreen style="color:green">0</span></a>
			<a id=prerv onclick="  sched_breack();" class="ui-btn ui-corner-all ui-btn-inline" style="z-index:12" >Прервать</a>
		</div>
		</div>
		<div data-role="content" id='my_sched'>
		</div>
	</div>
	
	
	
	
	
	<div data-role="page" data-close-btn="right" id="myDialog">
		<div data-role="header">
			<h2>Dialog</h2>
		</div>
		<div role="main" class="ui-content">
		<p id="p_dialog"></p>
		<a class="ui-link ui-btn ui-btn-b ui-shadow ui-corner-all" data-theme="b" data-rel="back" data-role="button"  role="button">
    Ok, I get it</a>
		</div>
	</div>
 
		<div data-role="page" data-close-btn="none" id="myDialog1">
		<div data-role="header">
			<h2>Задание выполнено!</h2>
		</div>
		<div role="main" class="ui-content">
			<p id="p_dialog1"></p>
			<table><tr><td>
	<label class="flip-1">Все полностью&nbsp&nbsp&nbsp</label></td><td>
    <select id="fl1" name="flip-1" data-role="slider">
        <option value=0>Нет</option>
        <option value=1>Да</option>
    </select></td></tr><tr><td>
	<label class="flip-1">Качественно&nbsp&nbsp&nbsp</label></td><td>
    <select id="fl2" name="flip-1" data-role="slider">
        <option value=0>Нет</option>
        <option value=1>Да</option>
    </select></td></tr><tr><td>
	<label class="flip-1">Без отвлечений&nbsp&nbsp&nbsp</label></td><td>
	<select id="fl3" name="flip-2" data-role="slider">
        <option value=0>Нет</option>
        <option value=1>Да</option>
    </select></td></tr><tr><td>
	<label class="flip-1">C&nbsp&nbsp&nbsp</label></td><td>
	<select id="fl4">
	    <option value="0">???</option>
		<option value="3">плохим</option>
		<option value="2">не очень</option>
		<option value="1">отличным</option>
	</select></td><td>
	<label class="flip-1">&nbsp&nbsp&nbsp настроением
	</td></tr></table>
<a class="ui-link ui-btn ui-btn-inline ui-shadow ui-corner-all" data-theme="b" data-rel="back" data-role="button"  role="button" id='sch_task_stop'>
Подтверждаю
</a>
<a class="ui-link ui-btn ui-btn-inline ui-shadow ui-corner-all" data-theme="b" data-rel="back" data-role="button"  role="button">
Не подтверждаю
</a>
</div>
	</div>
	

[/not-group]
	
	<script type="text/javascript">
	// <![CDATA[
		(function(doc) {

		var addEvent = 'addEventListener',
		type = 'gesturestart',
		qsa = 'querySelectorAll',
		scales = [1, 1],
		meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];

		function fix() {
		meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
		doc.removeEventListener(type, fix, true);
		}

		if ((meta = meta[meta.length - 1]) && addEvent in doc) {
		fix();
		scales = [.25, 1.6];
		doc[addEvent](type, fix, true);
		}

		}(document));
	// ]]>
	</script>
</body>
</html>