<script src="/templates/Smartphone/js/jquery-1.11.1.min.js"></script>
<meta name="viewport" content="width=device-width">
<script src="/templates/Smartphone/js/jquery-ui.js"></script>
<link  href="/templates/Smartphone/css/jquery-ui.css">
<script type="text/javascript">
$(function(){
	shift=0;
	high=document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientHeight:document.body.clientHeight/4*3;
//	alert(~~high);
	str=$("#main").html();	
	var arr = str.toUpperCase().replace(/<[^>]+>/g,'').replace(/[:;"',.-]/g, '').replace(/[\n]/g, ' <br>').replace(/  /g, ' ').split(' ');
	new_str='';
	$.each(arr,function(i,elem) {
		new_str+="<span class=word id=wn" +i+">"+ elem+"</span>&nbsp&nbsp&nbsp&nbsp ";
		});
	$("#www1").html(new_str);
	$("span:first").attr('style',"background-color:#22ffff");
	$("span:first").attr('current',"1");
	$( ".word" ).dblclick(function() {
	$('[current]').removeAttr("style");
	$('[current]').removeAttr("current");
	$(this).attr('style',"background-color:#22ffff");
	$(this).attr('current',"1");
});
});
function tranz() {
	id=$('[current]').attr('id');
	next= 'wn'+(id.substr(2)*1+1);
	var br=$('#'+next)[0].getBoundingClientRect();

skr=~~br.top;
if(skr>high){
	shift=shift+high-100;
	$('[current]').removeAttr("current");
	$('#'+id).removeAttr("style");
	var br=$('#'+next)[0].getBoundingClientRect();
	$('#www').html("&nbsp"+$('#'+next).html().replace(/<[^>]+>/g,'')+"&nbsp");
	$('#www').attr('style',"position: fixed;top:"+~~br.top+"px; left:"+~~br.left+"px ;background: #22ffff;font:  bold 88px arial, sans-serif;");
	$('#www').animate({ fontSize: "95px" }, 200 );
		$('#'+next).attr('style',"background: #22ffff;font:  bold 88px arial, sans-serif;");
	$('#'+next).attr('current',"1");
$('body').animate({scrollTop:shift}, 800,function() {
	
//alert(shift);
	

  });
}
else{
	$('[current]').removeAttr("current");
	$('#'+id).removeAttr("style");

	$('#www').html("&nbsp"+$('#'+next).html().replace(/<[^>]+>/g,'')+"&nbsp");
	$('#www').attr('style',"position: fixed;top:"+~~br.top+"px; left:"+~~br.left+"px ;background: #22ffff;font:  bold 88px arial, sans-serif;");
	$('#www').animate({ fontSize: "95px" }, 200 );
		$('#'+next).attr('style',"background: #22ffff;font:  bold 88px arial, sans-serif;");
	$('#'+next).attr('current',"1");
}}
window.onscroll = function() {
	$('#www').hide();
	
	
}
</script>

<div id=main  style="opacity: 0;font:  bold 38px arial, sans-serif; line-height: 1.5;">
Стрекоза и муравей

Попрыгунья Стрекоза
Лето красное пропела;
Оглянуться не успела,
Как зима катит в глаза.
Помертвело чисто поле;
Нет уж дней тех светлых боле,
Как под каждым ей листком
Был готов и стол и дом.
Всё прошло: с зимой холодной
Нужда, голод настает;
Стрекоза уж не поет:
И кому же в ум пойдет
На желудок петь голодный!
Злой тоской удручена,
К Муравью ползет она:
"Не оставь меня, кум милый!
Дай ты мне собраться с силой
И до вешних только дней
Прокорми и обогрей!"-
"Кумушка, мне странно это:
Да работала ль ты в лето?"-
Говорит ей Муравей.
"До того ль, голубчик, было?
В мягких муравах у нас -
Песни, резвость всякий час,
Так что голову вскружило".-
"А, так ты..." - "Я без души
Лето целое всё пела".-
"Ты всё пела? Это дело:
Так пойди же, попляши!"
Муха-цокатуха

Муха, Муха - Цокотуха,
Позолоченное брюхо!
Муха по полю пошла,
Муха денежку нашла.
Пошла Муха на базар
И купила самовар:
"Приходите, тараканы,
Я вас чаем угощу!"
Тараканы прибегали,
Все стаканы выпивали,
А букашки -
По три чашки
С молоком
И крендельком:
Нынче Муха-Цокотуха
Именинница!
Приходили к Мухе блошки,
Приносили ей сапожки,
А сапожки не простые -
В них застежки золотые.
Приходила к Мухе
Бабушка-пчела,
Мухе-Цокотухе
Меду принесла...
"Бабочка-красавица.
Кушайте варенье!
Или вам не нравится
Наше угощенье?"
Вдруг какой-то старичок
Паучок
Нашу Муху в уголок
Поволок -
Хочет бедную убить,
Цокотуху погубить!
"Дорогие гости, помогите!
Паука-злодея зарубите!
И кормила я вас,
И поила я вас,
Не покиньте меня
В мой последний час!"
Но жуки-червяки
Испугалися,
По углам, по щелям
Разбежалися:
Тараканы
Под диваны,
А козявочки
Под лавочки,
А букашки под кровать -
Не желают воевать!
И никто даже с места
Не сдвинется:
Пропадай-погибай,
Именинница!

Трезор

На дверях висел Замок. 
Взаперти сидел Щенок. 
Все ушли И одного 
В доме Заперли его.
Мы оставили Трезора
Без присмотра,
Без надзора. 
И поэтому щенок
Перепортил всё, что мог. 
Разорвал на кукле платье,
Зайцу выдрал шерсти клок, 
В коридор из-под кровати 
Наши туфли уволок. 
Под кровать загнал кота- 
Кот остался без хвоста. 
Отыскал на кухне угол - 
С головой забрался в уголь, 
Вылез чёрный -не узнать. 
Влез в кувшин -Перевернулся, 
Чуть совсем не захлебнулся 
И улёгся на кровать Спать... 
Мы щенка в воде и мыле 
Два часа мочалкой мыли. 
Ни за что теперь его 
Не оставим одного! 
Грека
Ехал Грека через реку. 
Видит Грека в реке рак. 
Сунул в реку руку Грека. 
Рак за руку Грека -цап. 
Курочка Ряба
Жили-были дед да баба. 
И была у них Курочка Ряба. 
Снесла курочка яичко, 
да не простое -золотое. 
Дед бил -не разбил. 
Баба била -не разбила. 
А мышка бежала, хвостиком 
махнула, яичко упало и разбилось. 
Плачет дед, плачет баба 
и говорит им Курочка Ряба: 
-Не плачь, дед, не плачь, 
баба: снесу вам новое  
яичко не золотое, а простое! 

</div>

<div id=www1 onclick=tranz() style ="position: absolute; left:0px; top: 0px;opacity: 1;font:  bold 88px arial, sans-serif; line-height: 1.5;"></div>
<div id=www style ="position: absolute; left: 500px; top: 500px;background: #e0e0e0;">cytsu</div>
	<?php
/* 	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	$link = mysql_connect("localhost", "root", "tarhush") or die("Could not connect");
	mysql_select_db("cw") or die("Could not select database");
	mysql_query("SET NAMES utf8");
	$query = "SELECT rules.id,rule,user_id, payment, hm_times   FROM `rules` where date_end='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='illya') ORDER BY `rules`.`rule` ASC";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table border=3>');echo("<tr style='background:red' ><td><div align=center style='font-size: 25pt;'>ИЛЬЯ</div></td></tr>");
	while (list($rule_id, $rule_name, $user_id, $payment, $hm_times) = mysql_fetch_row($result2) )
	{
		echo("<tr onclick='tranz($rule_id,".'"'.'illya'.'"'.")'><td><a style='font-size: 21pt;'".">$rule_name</a></td></tr>");
	}
	echo ("</table>");
	
	$query = "SELECT rules.id,rule,user_id, payment, hm_times   FROM `rules` where date_end='0000-00-00 00:00:00' and user_id=(SELECT user_id from dle_users where name='Ann') ORDER BY `rules`.`rule` ASC";
	$result2 = mysql_query($query) or die("Query failed3");echo('<br><table border=3>');echo("<tr style='background:red'><td><div align=center style='font-size: 25pt;'>АННА</div></td></tr>");
	while (list($rule_id, $rule_name, $user_id, $payment, $hm_times) = mysql_fetch_row($result2) )
	{
		echo("<tr onclick='tranz($rule_id,".'"'.'Ann'.'"'.")'><td><a  style='font-size: 21pt;'".">$rule_name</a></td></tr>");
	}
	echo ("</table>"); */
?>