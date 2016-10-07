<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<link media="screen" href="/templates/Smartphone/css/jquery.mobile-1.4.3.min.css" type="text/css" rel="stylesheet" />
<script src="/templates/Smartphone/js/jquery.mobile-1.4.3.min.js" type="application/x-javascript" charset="utf-8"></script>
<head>
	<title>
		Jack
	</title>
</head>
<body>
	<?php 
		$type_get = $_GET['type'];
		$wrong_get = $_GET['wrong'];
		$total_get = $_GET['total'];
		$time_get = $_GET['time'];
		$u_name = $_GET['u_name'];
		$action = $_GET['action'];
		//$schedule_id = $_GET['schedule_id'];
		$first_min = $_GET['first_min'];
		$first_max = $_GET['first_max'];
		$second_min = $_GET['second_min'];
		$second_max = $_GET['second_max'];
	?>
	<script type="text/javascript" language="javascript">
		$(document).ready(ready_1);
        function ready_1(){

			//СОЗДАНИЕ ВСПОМОГАТЕЛЬНЫХ МАССИВОВ С МАТЕМАТИЧЕСКИМИ ДЕЙСТВИЯМИ И ПРИМЕРАМИ (BEGIN)
			var actions_array = ['+','-','*',':','/']; //массив из математических действий
			var plus_or_minus_array = [1,-1]; //массив для создания случайного знака перед числом
			var actions_array_new_type = ['']; //массив из примеров с тремя неизвестными
			var simple_equation_html = "<span id='first_number'></span>x  <span id='action'></span>  <span id='second_number'></span>  =  <span id='third_number'></span>            x<span id='type_of_example' value='simple_equation'></span>"; //html-код для уравнения с одним неизвестным первой степени    a*X ? b = c
			var simple_fraction_html = "<span id='first_number'></span>/<span id='second_number'></span>  <span id='action'></span>  <span id='third_number'></span>/<span id='fourth_number'></span><span id='type_of_example' value='simple_fraction'></span>"; //html-код для обыкновенных дробей    a/b ? c/d
			var first_type_for_new_array = "<span id='first_number'></span>  <span id='sign_between_1_and_2'></span>  <span id='second_number'></span>  <span id='sign_between_2_and_3'></span>  <span id='third_number'></span><span id='type_of_example' value='first'></span>"; //html-код для примера с тремя числами    A ? B ? C
			var second_type_for_new_array = "(<span id='first_number'></span>  <span id='sign_between_1_and_2'></span>  <span id='second_number'></span>)  <span id='sign_between_2_and_3'></span>  <span id='third_number'></span><span id='type_of_example' value='second'></span>"; //html-код для примера с тремя числами    (A ? B) ? C
			var third_type_for_new_array = "<span id='first_number'></span>  <span id='sign_between_1_and_2'></span>  (<span id='second_number'></span>  <span id='sign_between_2_and_3'></span>  <span id='third_number'></span>)<span id='type_of_example' value='third'></span>"; //html-код для примера с тремя числами    A ? (B ? C)
			actions_array_new_type.push(first_type_for_new_array);
			actions_array_new_type.push(second_type_for_new_array);
			actions_array_new_type.push(third_type_for_new_array);
			//СОЗДАНИЕ ВСПОМОГАТЕЛЬНЫХ МАССИВОВ С МАТЕМАТИЧЕСКИМИ ДЕЙСТВИЯМИ И ПРИМЕРАМИ (END)
			
			
			
			//СЧИТЫВАНИЕ ПОЛУЧЕННЫХ ПАРАМЕТРОВ ЗАДАНИЯ (BEGIN)
			
			var USER_NAME = '<?php echo $u_name; ?>'; //ID пользователя, выполняющего задание
			var ID_FOR_DATABASE = '<?php echo $action; ?>'; //ID типа примера
			var FIRST_MIN = <?php echo $first_min; ?>; //минимально возможное сгенерированное первое число
			var FIRST_MAX = <?php echo $first_max; ?>; //максимально возможное сгенерированное первое число
			var SECOND_MIN = <?php echo $second_min; ?>; //минимально возможное сгенерированное второе число
			var SECOND_MAX = <?php echo $second_max; ?>; //максимально возможное сгенерированное второе число
			var ACTION_CHOSEN = '<?php echo $type_get; ?>'; //выбранное математическое действие
			var ADD_EXAMPLES_TIME = <?php echo $time_get; ?>; //порог добавления примеров при невыполнении одного за заданное время
			var ADD_EXAMPLES_AMOUNT = 1; //количество примеров, добавляемых при прохождении порога выше
			var ADD_FOR_WRONG_ANSWER = <?php echo $wrong_get; ?>; //количество примеров, добавляемых за неправильный ответ
			var START_EXAMPLES = <?php echo $total_get; ?>; //начальное количество примеров
			if(ADD_EXAMPLES_TIME > 60){ //если количество секунд больше 60, разбивается на минуты и секунды
				ADD_EXAMPLES_MINUTES = Math.floor(ADD_EXAMPLES_TIME/60); //минуты
				ADD_EXAMPLES_SECONDS = ADD_EXAMPLES_TIME - ADD_EXAMPLES_MINUTES*60; //cекунды
			}
			
			//СЧИТЫВАНИЕ ПОЛУЧЕННЫХ ПАРАМЕТРОВ ЗАДАНИЯ (END)
			
			
			
			//СОЗДАНИЕ ГЛОБАЛЬНЫХ ПЕРЕМЕННЫХ (BEGIN)
			var start_time_timeout = 0; 
			var current_minute = 0;
			var current_second = 0;
			var text_minute = 0;
			var text_second = 0;
			var right_answers = 0;
			var wrong_answers = 0;
			var solved_examples = 0;
			var total_examples = START_EXAMPLES;
			var first_number = 0;
			var second_number = 0;
			var third_number = 0;
			var fourth_number = 0;
			var first_sign = '';
			var second_sign = '';
			var third_sign = '';
			var sign_between_1_and_2 = '';
			var sign_between_2_and_3 = '';
			var total_time_second = 0;
			var min1, min2, min3, min4, max1, max2, max3, max4;
			//СОЗДАНИЕ ГЛОБАЛЬНЫХ ПЕРЕМЕННЫХ (END)
			
			
			
			text_examples_func();
			
			
			
			//НАЗНАЧЕНИЕ ФУНКЦИЙ НА HTML-ТЕГИ (BEGIN)
		    $(".answers").keyup(function(event){ //перхват нажатия "Enter" в любом поле ввода
				if (event.keyCode == 13) {
					var type_of_example = $("#type_of_example").attr('value');
					switch(type_of_example){
						case 'simple' : { //обычные примеры
							check_answer_simple();
							break;
						}
						case 'first' : { //первый тип примеров с тремя числами
							check_answer_first_type();
							break;
						}
						case 'second' : { //второй тип примеров с тремя числами
							check_answer_second_type();
							break;
						}
						case 'third' : { //третий тип примеров с тремя числами
							check_answer_third_type();
							break;
						}
						case 'decimal' : { //десятичные дроби
							check_answer_decimal();
							break;
						}
						case 'simple_fraction' : { //обыкновенные дроби
							check_answer_simple_fraction();
							break;
						}
						case 'simple_equation' : { //уравнение первой степени с одним неизвестным
							check_answer_simple_equation();
							break;
						}
					}
				}
			});
			$("#button_generate").click(function(){ //при нажатии начинается тестирование
				switch(ACTION_CHOSEN){ //проверка выбранного задания
					case 'three_numbers' : { //примеры с тремя числами
						generate_three_numbers();
						break;
					}
					case 'decimal' : { //десятичные дроби
						generate_decimal();
						break;
					}
					case 'simple_fraction' : { //обыкновенные дроби
						$("#area_for_another_type").html(simple_fraction_html);
						generate_simple_fraction();
						break;
					}
					case 'simple_equation' : { //уравнение первой степени с одним неизвестным
						$("#area_for_another_type").html(simple_equation_html);
						generate_simple_equation();
						break;
					}
					default : { //обычные примеры
						generate();
						break;
					}
				}
				counter_start(); //включение счётчика
				$("#answer_1").focus();
			});
			//$("#all_examples_div").mouseleave(function(event){ //защита от жульничества
			//	total_examples = total_examples + 5;
			//	text_examples_func();
			//});
			//НАЗНАЧЕНИЕ ФУНКЦИЙ НА HTML-ТЕГИ (END)
			
			
			
			//ГЕНЕРАЦИЯ ПРИМЕРОВ (BEGIN)
			function generate (){ //генерирование примера по заданным параметрам
				var action = random_action();
				$("#action").text(action);
				switch(action){
					case "+" : { //сложение
						first_number = random_number(7,26);
						second_number = random_number(1,19);
						$("#answer_2").attr("disabled","disabled");
						break;
					}
					case "-" : { //вычитание
						second_number = random_number(101,495);
						while (second_number > first_number){
							first_number = random_number(569,999);
						}
						$("#answer_2").attr("disabled","disabled");
						break;
					}
					case "*" : { //умножение
			
						if(FIRST_MIN == ''){ 
							min1 = 2;       
						}
						else{
							min1 = FIRST_MIN;
						}
						if(FIRST_MAX == ''){ 
							max1 = 20;
						}
						else{
							max1 = FIRST_MAX;
						}
						if(SECOND_MIN == ''){
							min2 = 2;
						}
						else{
							min2 = SECOND_MIN;
						}
						if(SECOND_MAX == ''){ 
							max2 = 20;
						}
						else{ 
							max2 = SECOND_MAX;
						} 
						first_number = random_number(min1,max1);
						second_number = random_number(min2,max2);
						$("#answer_2").attr("hidden","hidden");
						break;
					}
					case ":" : { //деление
						first_number = random_number(10,20);
						second_number = random_number(2,5);
						first_number = first_number * second_number;
						$("#answer_2").attr("hidden","hidden");
						break;
					}
					case "/" : { //деление с остатком
						first_number = random_number(10,25);
						second_number = random_number(8,29);
						first_number = first_number * second_number;
						var third_number = second_number;
						while (third_number == second_number){
							third_number = random_number(1,second_number); //random_number(1,second_number);
						}
						first_number = first_number + third_number;
						$("#answer_2").removeAttr("hidden"); //активация поля для ввода остатка
						break;
					}
				}
				text_and_null();
			}
			function generate_three_numbers (){ //генерация примеров с тремя числами
				first_sign = random_action_new_type(1);
				second_sign = random_action_new_type(1);
				third_sign = random_action_new_type(1);
				sign_between_1_and_2 = random_action_new_type(3);
				sign_between_2_and_3 = random_action_new_type(3);
				
				var chanse = Math.round(Math.random()*2); //случайным образом одно из чисел будет меньше 10
				switch(chanse){
					case 0 : {
						first_number = random_number(2,9);
						second_number = random_number(2,99);
						third_number = random_number(2,99);
						break;
					}
					case 1 : {
						first_number = random_number(2,99);
						second_number = random_number(2,9);
						third_number = random_number(2,99);
						break;
					}
					case 2 : {
						first_number = random_number(2,99);
						second_number = random_number(2,99);
						third_number = random_number(2,9);
						break;
					}
				}
/* 				alert(first_number);
				alert(second_number);
				alert(third_number); */
				if(sign_between_1_and_2 == ':'){ //создание чисел, делящихся нацело
					first_number = first_number * second_number;
					if(sign_between_2_and_3 == ':'){
						second_number = second_number * third_number;
					}
				}
				else if(sign_between_2_and_3 == ':'){
					second_number = second_number * third_number;
				}
				text_and_null_three_numbers();
			}
			function generate_decimal (){ //генерация примеров с десятичными дробями
				$("#answer_2").removeAttr("hidden"); //включение дополнительного поля ответов
				var action = random_action();
				$("#type_of_example").attr('value','decimal'); //назначение типа примера на десятичный для выбора проверки ответов
				$("#supporting_sign").text(',');
				$("#action").text(action);
				switch(action){
					case "+" : { //сложение
						first_number = random_number(1001,9999)/100;
						second_number = random_number(1001,9999)/100;
						break;
					}
					case "-" : { //вычитание
						second_number = random_number(1001,8999)/100;
						while (second_number > first_number){
							first_number = random_number(1001,9999)/100;
						}
						break;
					}
					case "*" : { //умножение
						first_number = random_number(101,999)/100;
						second_number = random_number(11,99)/10;
						break;
					}
					case ":" : { //деление
						first_number = random_number(11,99);
						second_number = random_number(11,99);
						first_number = first_number * second_number/100;
						second_number = second_number/10;
						break;
					}
				}
				text_and_null();
			}
			function generate_simple_fraction (){ //генерация примеров с обыкновенными дробями
				$("#answer_2").removeAttr("disabled"); //включение дополнительного поля ответов
				var action = random_action();
				$("#supporting_sign").text('/');
				$("#action").text(action);
				switch(action){
					case "+" : { //сложение
						first_number = random_number(1,9);
						second_number = random_number(1,9);
						third_number = random_number(1,9);
						fourth_number = random_number(1,9);
						break;
					}
					case "-" : { //вычитание
						first_number = random_number(1,9);
						second_number = random_number(1,9);
						third_number = random_number(1,9);
						fourth_number = random_number(1,9);
						break;
					}
					case "*" : { //умножение
						first_number = random_number(2,9);
						second_number = random_number(2,3);
						third_number = random_number(2,9);
						fourth_number = random_number(2,9);
						break;
					}
					case ":" : { //деление
						first_number = random_number(2,9);
						second_number = random_number(2,9);
						third_number = random_number(2,9);
						fourth_number = random_number(2,9);
						break;
					}
				}
				text_and_null_simple_fraction();
			}
			function generate_simple_equation (){ //генерация примеров Ax + B = C
				var action = random_action();
				$("#action").text(action);
				first_sign = plus_or_minus();
				second_sign = plus_or_minus();
				third_sign = plus_or_minus();
				var subnumber1 = 0;
				var subnumber2 = 0;
				switch(action){
					case "+" : { //сложение  Ax + B = C  Ax = C - B  x = (C - B)/A
						first_number = random_number(1,9)*first_sign;
						subnumber1 = random_number(1,9);
						subnumber2 = first_number * subnumber1; 
						second_number = random_number(1,9); 
						third_number = (subnumber2 + second_number); 
						break;
					}
					case "-" : { //вычитание
						first_number = random_number(1,9)*first_sign;
						subnumber1 = random_number(1,9);
						subnumber2 = first_number * subnumber1; 
						second_number = random_number(1,9); 
						third_number = (subnumber2 - second_number); 
						break;
					}
					case "*" : { //умножение
						first_number = random_number(1,9)*first_sign;
						second_number = random_number(1,9)*second_sign; // x = C / (A*B)
						third_number = first_number*second_number*random_number(1,9)*third_sign;
						break;
					}
					case ":" : { //деление
						first_number = random_number(1,4)*first_sign; // Ax / B = C   x = C * B / A
						second_number = random_number(1,5); 
						third_number = first_number*random_number(1,9)*third_sign; 
						break;
					}
				}
				text_and_null_three_numbers();
			}
			//ГЕНЕРАЦИЯ ПРИМЕРОВ (END)
			
			
			
			//ПРОВЕРКА ОТВЕТОВ (BEGIN)
			function check_answer_decimal (){ //проверка ответа для десятичных дробей
				var action = $("#action").text(); //считывание математического действия
				var integral_part = $("#answer_1").val(); //считывание знака до запятой
				var fractional_part = $("#answer_2").val(); //считывание знака после запятой
				var final_answer = '';
				var legth_of_fractional_part = fractional_part.length; //количество знаков после запятой
				final_answer = integral_part + fractional_part; //составление ответа из чисел до и после запятой
				final_answer = final_answer * 1; //превращение строки в число
				//final_answer = final_answer / Math.pow(10, legth_of_fractional_part); //создание запятой на нужном месте
				
				$(".answers").val('');
				$("#answer_1").focus();
				var first_number = $("#first_number").text()*1; //считывание первого числа
				var second_number = $("#second_number").text()*1; //считывание второго числа
				var local_answer = 0;
				switch(action) { //проверка ответа по математическому действию
					case "+" : {
						first_number = Math.round(first_number * 100);
						second_number = Math.round(second_number * 100);
						local_answer = first_number + second_number;
						break;
					}
					case "-" : {
						first_number = Math.round(first_number * 100);
						second_number = Math.round(second_number * 100);
						local_answer = first_number - second_number;
						break;
					}
					case "*" : {
						first_number = Math.round(first_number * 100);
						second_number = Math.round(second_number * 10);
						local_answer = Math.round(first_number * second_number);
						break;
					}
					case ":" : {
						first_number = Math.round(first_number * 100);
						second_number = Math.round(second_number * 10);
						local_answer = Math.round(first_number / second_number);
						break;
					}
				}
				
				test_final_answer = final_answer;
				test_local_answer = local_answer;
				while(test_final_answer == final_answer){
					test_final_answer = Math.round(test_final_answer/10);
					final_answer = final_answer/10;
				}
				final_answer = final_answer*10;
				while(test_local_answer == local_answer){
					test_local_answer = Math.round(test_local_answer/10);
					local_answer = local_answer/10;
				}
				local_answer = local_answer*10;
				
				if(final_answer == local_answer){ //проверка правильности ответа
					right_answer();
				}
				else{
					wrong_answer();
				}
			}
			function check_answer_simple (){ //проверка ответа для обычных примеров
				var action = $("#action").text(); //считывание математического действия
				var answer = $("#answer_1").val(); //считывание ответа
				$("#answer_1").val('');
				$("#answer_1").focus();
				var first_number = $("#first_number").text()*1; //считывание первого числа
				var second_number = $("#second_number").text()*1; //считывание второго числа
				var local_answer = 0;
				switch(action) { //проверка ответа по математическому действию
					case "+" : {
						local_answer = first_number + second_number;
						break;
					}
					case "-" : {
						local_answer = first_number - second_number;
						break;
					}
					case "*" : {
						local_answer = first_number * second_number;
						break;
					}
					case ":" : { //деление
						local_answer = first_number / second_number;
						break;
					}
					case "/" : { //деление с остатком
						var answer2 = $("#answer_2").val();
						local_answer = (first_number - answer2) / second_number;
						$("#answer_2").val('');
						break;
					}
				}
				if(answer == local_answer){ //проверка правильности ответа
					right_answer();
				}
				else{
					wrong_answer();
				}
			}
			function check_answer_simple_fraction (){ //проверка ответа для обыкновенных дробей
				var action = $("#action").text(); //считывание математического действия
				var answer1 = $("#answer_1").val(); //считывание числителя
				var answer2 = $("#answer_2").val(); //считывание знаменателя
				$(".answers").val('');
				$("#answer_1").focus();
				var first_number = $("#first_number").text()*1; //числитель первого числа
				var second_number = $("#second_number").text()*1; //знаменатель первого числа
				var third_number = $("#third_number").text()*1; //числитель первого числа
				var fourth_number = $("#fourth_number").text()*1; //знаменатель первого числа
				
				var local_answer1 = 0;
				var local_answer2 = 0;
				switch(action) { //проверка ответа по математическому действию
					case "+" : {
						local_answer1 = (first_number*fourth_number) + (third_number*second_number); //числитель
						local_answer2 = second_number*fourth_number; //знаменатель
						break;
					}
					case "-" : {
						local_answer1 = (first_number*fourth_number) - (third_number*second_number);
						local_answer2 = second_number*fourth_number;
						break;
					}
					case "*" : {
						local_answer1 = first_number*third_number;
						local_answer2 = second_number*fourth_number;
						break;
					}
					case ":" : { //деление
						local_answer1 = first_number*fourth_number;
						local_answer2 = second_number*third_number;
						break;
					}
				}
				var last_answer1 = answer1*local_answer2;
				var last_answer2 = answer2*local_answer1;
				if((last_answer1/last_answer2) == 1){ //проверка правильности ответа
					right_answer();
				}
				else{
					wrong_answer();
				}
			}
			function check_answer_first_type (){ //примеры без скобок a ? b ? c
				var local_answer = 0;
				var answer = $("#answer_1").val();
				var first_number = $("#first_number").attr('value')*1;
				var second_number = $("#second_number").attr('value')*1;
				var third_number = $("#third_number").attr('value')*1;
				var sign_between_1_and_2 = $("#sign_between_1_and_2").text();
				var sign_between_2_and_3 = $("#sign_between_2_and_3").text();
				$("#answer_1").val('');
				$("#answer_1").focus();
				
				switch(sign_between_1_and_2){
					case '+' : {
						local_answer = first_number + get_answer_by_action(second_number,third_number,sign_between_2_and_3);
						break;
					}
					case '-' : {
						local_answer = first_number - get_answer_by_action(second_number,third_number,sign_between_2_and_3);
						break;
					}
					case '*' : {
						local_answer = get_answer_by_action(first_number*second_number,third_number,sign_between_2_and_3);
						break;
					}
					case ':' : {
						local_answer = get_answer_by_action(first_number/second_number,third_number,sign_between_2_and_3);
						break;
					}
				}
				if(local_answer == answer){
					right_answer();
				}
				else{
					wrong_answer();
				}
			}
			function check_answer_second_type (){ //примеры со скобками в положении (a ? b) ? c
				var local_answer = 0;
				var answer = $("#answer_1").val();
				var first_number = $("#first_number").attr('value')*1;
				var second_number = $("#second_number").attr('value')*1;
				var third_number = $("#third_number").attr('value')*1;
				var sign_between_1_and_2 = $("#sign_between_1_and_2").text();
				var sign_between_2_and_3 = $("#sign_between_2_and_3").text();
				$("#answer_1").val('');
				$("#answer_1").focus();
				
				switch(sign_between_1_and_2){
					case '+' : {
						local_answer = get_answer_by_action(first_number+second_number,third_number,sign_between_2_and_3);
						break;
					}
					case '-' : {
						local_answer = get_answer_by_action(first_number-second_number,third_number,sign_between_2_and_3);
						break;
					}
					case '*' : {
						local_answer = get_answer_by_action(first_number*second_number,third_number,sign_between_2_and_3);
						break;
					}
					case ':' : {
						local_answer = get_answer_by_action(first_number/second_number,third_number,sign_between_2_and_3);
						break;
					}
				}
				if(local_answer == answer){
					right_answer();
				}
				else{
					wrong_answer();
				}
			}
			function check_answer_third_type (){ //примеры со скобками в положении a ? (b ? c)
				var local_answer = 0;
				var answer = $("#answer_1").val();
				var first_number = $("#first_number").attr('value')*1;
				var second_number = $("#second_number").attr('value')*1;
				var third_number = $("#third_number").attr('value')*1;
				var sign_between_1_and_2 = $("#sign_between_1_and_2").text();
				var sign_between_2_and_3 = $("#sign_between_2_and_3").text();
				$("#answer_1").val('');
				$("#answer_1").focus();
				
				switch(sign_between_1_and_2){
					case '+' : {
						local_answer = first_number + get_answer_by_action(second_number,third_number,sign_between_2_and_3);
						break;
					}
					case '-' : {
						local_answer = first_number - get_answer_by_action(second_number,third_number,sign_between_2_and_3);
						break;
					}
					case '*' : {
						local_answer = first_number * get_answer_by_action(second_number,third_number,sign_between_2_and_3);
						break;
					}
					case ':' : {
						local_answer = first_number / get_answer_by_action(second_number,third_number,sign_between_2_and_3);
						break;
					}
				}
				if(local_answer == answer){
					right_answer();
				}
				else{
					wrong_answer();
				}
			}
			function get_answer_by_action (first,second,action){ //получение ответа для примеров с тремя числами
				switch(action){
					case '+' : {
						return first+second;
						break;
					}
					case '-' : {
						return first-second;
						break;
					}
					case '*' : {
						return first*second;
						break;
					}
					case ':' : {
						return first/second;
						break;
					}
				}
			}
			function check_answer_simple_equation (){ //проверка ответа для обычных примеров
				var action = $("#action").text(); //считывание математического действия
				var answer = $("#answer_1").val(); //считывание ответа
				$("#answer_1").val('');
				$("#answer_1").focus();
				var first_number = $("#first_number").attr('value')*1;
				var second_number = $("#second_number").attr('value')*1;
				var third_number = $("#third_number").attr('value')*1;
				var local_answer = 0;
				switch(action) { //проверка ответа по математическому действию
					case "+" : {
						local_answer = (third_number - second_number)/first_number; // x = (B-C)/A
						break;
					}
					case "-" : {
						local_answer = (third_number + second_number)/first_number;
						break;
					}
					case "*" : {
						local_answer = third_number/(second_number*first_number);
						break;
					}
					case ":" : { //деление
						local_answer = (third_number*second_number)/first_number;
						break;
					}
				}
				if(answer == local_answer){ //проверка правильности ответа
					right_answer();
				}
				else{
					wrong_answer();
				}
			}
			//ПРОВЕРКА ОТВЕТОВ (END)
			
			
			
			//ВЫВОД ИНТЕРАКТИВНОЙ ИНФОРМАЦИИ (BEGIN)
			function right_answer (){ //правильный ответ
				right_answers = right_answers + 1;
				total_examples = total_examples - 1;
				text_examples_func();
				if(total_examples == 0){ //если тестирование закончено, передаём результаты в базу данных
					clearInterval(start_time_timeout); //сброс счётчика
					send_results_to_database();
				}
				else{ //если не закончено, генерируется следующий пример
					switch(ACTION_CHOSEN){
						case 'three_numbers' : {
							generate_three_numbers();
							break;
						}
						case 'decimal' : {
							generate_decimal();
							break;
						}
						case 'simple_fraction' : { 
							generate_simple_fraction();
							break;
						}
						case 'simple_equation' : {
							generate_simple_equation();
							break;
						}
						default : {
							generate();
							break;
						}
					}
					current_second = ADD_EXAMPLES_SECONDS; //сброс счётчика на стартовое количество секунд
					current_minute = ADD_EXAMPLES_MINUTES; //сброс счётчика на стартовое количество минут
				}
			}
			function wrong_answer (){ //неправильный ответ
				$("#alert_wrong").fadeIn(3000,function(){
					$("#alert_wrong").fadeOut(3000);
				});
				wrong_answers = wrong_answers + 1;
				total_examples = total_examples + ADD_FOR_WRONG_ANSWER; //добавление примеров за неправильный ответ
				text_examples_func();
				current_second = ADD_EXAMPLES_SECONDS; //сброс счётчика на стартовое количество секунд
				current_minute = ADD_EXAMPLES_MINUTES; //сброс счётчика на стартовое количество минут
			}
			function text_and_null (){ //вывод сгенерированных чисел
				$("#first_number").text(first_number);
				$("#second_number").text(second_number);
				first_number = 0;
				second_number = 0;
			}
			function text_and_null_simple_fraction (){ //вывод сгенерированных чисел для обыкновенных дробей
				$("#first_number").text(first_number);
				$("#second_number").text(second_number);
				$("#third_number").text(third_number);
				$("#fourth_number").text(fourth_number);
				first_number = 0;
				second_number = 0;
				third_number = 0;
				fourth_number = 0;
			}
			function text_and_null_three_numbers (){ //вывод сгенерированных чисел для примеров с тремя числами
				switch(ACTION_CHOSEN){
					case 'three_numbers' : {
						$("#area_for_another_type").html(random_example_new_type()); //случайно вставляется пример из трёх возможных типов
						$("#sign_between_1_and_2").text(sign_between_1_and_2); //вывод математического действия из 4-х возможных
						$("#sign_between_2_and_3").text(sign_between_2_and_3);
					}
				}
				if(first_sign == '-' | first_number<0){ //знак перед числом, возможен "+" или "-"
					switch(ACTION_CHOSEN){
						case 'three_numbers' : {
							$("#first_number").text('(-'+first_number+')');
							first_number = first_number * (-1);
						}
						case 'simple_equation' : {
							$("#first_number").text('('+first_number+')');
						}
					}
				}
				else{
					$("#first_number").text(first_number);
				}
				if(second_sign == '-' | second_number<0){
					switch(ACTION_CHOSEN){
						case 'three_numbers' : {
							$("#second_number").text('(-'+second_number+')');
							second_number = second_number * (-1);
						}
						case 'simple_equation' : {
							$("#second_number").text('('+second_number+')');
						}
					}
				}
				else{
					$("#second_number").text(second_number);
				}
				if(third_sign == '-' | third_number<0){
					switch(ACTION_CHOSEN){
						case 'three_numbers' : {
							$("#third_number").text('(-'+third_number+')');
							third_number = third_number * (-1);
						}
						case 'simple_equation' : {
							$("#third_number").text('('+third_number+')');
						}
					}
				}
				else{
					$("#third_number").text(third_number);
				}
				
				$("#first_number").attr('value',first_number); //запись значения числа в атрибут "value" для последующего считывания
				$("#second_number").attr('value',second_number);
				$("#third_number").attr('value',third_number);
				
				first_number = 0; //обнуление чисел для предотвращения возникновения ошибок
				second_number = 0;
				third_number = 0;
			}
			function text_examples_func (){ //обновление общего количества задач
				if(total_examples<10){
					text_examples = '0'+total_examples; //для лучшего визуального восприятия
				}
				else{
					text_examples = total_examples;
				}
				$("#total").text(text_examples);
			}
			function counter_start (){ //включатель счётчика
				clearInterval(start_time_timeout); //отключение счётчика, на случай, если кнопка "Generate" была нажата повторна
				total_examples = START_EXAMPLES; //если нажата кнопка "Generate", возвращается стартовое количество примеров
				text_examples_func();
				current_minute = ADD_EXAMPLES_MINUTES; //если нажата кнопка "Generate", возвращение стартового количества минут
				current_second = ADD_EXAMPLES_SECONDS; //если нажата кнопка "Generate", возвращение стартового количества секунд
				start_time_timeout = setInterval(counter_function, 1000); //запуск функции каждые 1000 милисекунд (эквивалентно 1-й секунде)
			}
			function counter_function (){ //счётчик для выполнения одного примера
				current_second = current_second - 1;
				total_time_second = total_time_second + 1;
				if(current_second < 0){
					current_minute = current_minute - 1;
					current_second = current_second + 60;
				}
				if(current_minute < 0){ //если время на выполнение закончилось, добавляется заданное количество примеров
					$("#alert_time").fadeIn(3000,function(){
						$("#alert_time").fadeOut(3000);
					});
					total_examples = total_examples + ADD_EXAMPLES_AMOUNT; //добавление примеров
					text_examples_func();
					current_second = ADD_EXAMPLES_SECONDS; //сброс счётчика на стартовое количество секунд
					current_minute = ADD_EXAMPLES_MINUTES; //сброс счётчика на стартовое количество минут
				}
				else{
					if (current_minute < 10){
						text_minute = "0" + current_minute; //для лучшего визуального восприятия
					}
					else{
						text_minute = current_minute;
					}
					if (current_second < 10){
						text_second = "0" + current_second;
					}
					else{
						text_second = current_second;
					}
					$("#time_").text(text_minute + ":" + text_second); //вывод времени
				}

			}
			//ВЫВОД ИНТЕРАКТИВНОЙ ИНФОРМАЦИИ (END)
			
			
			
			//ГЕНЕРАТОРЫ ЧИСЕЛ И МАТЕМАТИЧЕСКИХ ДЕЙСТВИЙ (BEGIN)
			function random_action (){ //генерация математического действия по заданным параметрам
				switch(ACTION_CHOSEN){ //случайное математическое действие из всех возможных
					case 'all' : {
						var counter = Math.round(Math.random()*4);
						break;
					}
					case 'decimal' : { //десятичные дроби (отключено деление с остатком)
						var counter = Math.round(Math.random()*3);
						break;
					}
					case 'simple_fraction' : { //обыкновенные дроби (отключено деление с остатком)
						var counter = Math.round(Math.random()*3);
						break;
					}
					case 'simple_equation' : { //уравнение первой степени с одним неизвестным (отключено деление с остатком)
						var counter = Math.round(Math.random()*3);
						break;
					}
					default : { //постоянное математическое действие
						counter = ACTION_CHOSEN*1;
						break;
					}
				}
				return actions_array[counter];
			}
			function random_action_new_type (number){ //герерация математического от первого возможного до выбранного по номеру
				var counter = Math.round(Math.random()*number);
				return actions_array[counter];
			}
			function random_example_new_type (){ //генерация случайной расстановки скобок для примера с тремя числами
				return actions_array_new_type[Math.round(Math.random()*2)+1]; //один из трёх возможных типов примеров с тремя числами
			}
			function random_number (min, max){ //генерация случайного числа в пределах от min до max
				return Math.round(Math.random()*(max - min) + min);
			}
			function plus_or_minus (){ //генерация чисел 1 или -1
				var counter = Math.round(Math.random());
				return plus_or_minus_array[counter];
			}
			//ГЕНЕРАТОРЫ ЧИСЕЛ И МАТЕМАТИЧЕСКИХ ДЕЙСТВИЙ (END)
			
			
			
			//РАБОТА С БАЗОЙ ДАННЫХ (BEGIN)
			function send_results_to_database (){ //отправка результатов в базу данных
//				alert(total_time_second);
				$(".math_elements").fadeOut("slow");
				$("#interactive_information").fadeOut("slow");
				var total_answers_to_database = right_answers + wrong_answers;
				$("#alert_end").fadeIn("slow"); //отключение всех элементов для предотвращения ошибок
				str = '?total='+total_answers_to_database+'&wrong='+wrong_answers+'&u_name='+USER_NAME+'&time='+total_time_second+'&action='+ID_FOR_DATABASE; //данные для отправки в БД
				$.get('engine/modules/tech/math_to_results.php'+str, function(data){});
			}
			//РАБОТА С БАЗОЙ ДАННЫХ (END)
		}
	</script>
	<style>
		#interactive_information{font-size: 27pt;}
		#alerts{color: red; font-size: 15pt;}
		.math_elements{font-size: 17pt;}
		#all_examples_div{background: #252525; margin-left: 10px; margin-top: 10px}
	</style>
	<div id='all_examples_div'>
		<span class='math_elements'> <!-- Математические элементы -->
			<button id='button_generate'><h5>Generate</h5></button><br>
			<span id='area_for_another_type'>
				<span id='first_number'></span> 
				<span id='action'></span> 
				<span id='second_number'></span>
				<span id='type_of_example' value='simple'></span>
			</span>
			<span> = </span>
			<br>
			<input size='5' class='answers' id ='answer_1'> 
			<span id='supporting_sign'></span>
			<input size='5' class='answers' id ='answer_2' hidden>
		</span>
		<br>
		<b id='interactive_information'> <!-- Текущее количество заданий и время -->
			<span id='total'></span> 
			<span id='time_'></span> 
		</b>
		<br>
		<b id='alerts'> <!-- Уведомления -->
			<span id='alert_time' hidden>Added examples due to the slowness</span>
			<span id='alert_wrong' hidden>Added examples due to the wrong answer</span>
			<br>
			<span id='alert_end' hidden>Task accomplished ☺</span>
		</b>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</div>
</body>