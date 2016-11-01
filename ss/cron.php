<?php
ob_start();
require_once '../engine/modules/tech/includes/init.php';
echo "<pre>";
//task_overtime(); /* It is fail function task_overtime with sql error. Call DISABLED*/
checkstoppedActions();

//sched_lowtime(); incorrect works 
skipping_task();
delete_old_pics();

function listFolderFiles($dir){
	$ffs = scandir($dir);
	echo '<ol>';
	foreach($ffs as $ff){
		if($ff != '.' && $ff != '..'){
			echo '<li>'.$ff;
			if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
			else {
				$aParts = explode(".",$ff);
				if(count($aParts) && $aParts[count($aParts)-1]=='jpg') {
					unlink($dir . '/' . $ff);
					echo "\t Deleted";
				}
			}
			echo '</li>';
		}
	}
	echo '</ol>';
}


function delete_old_pics() {

    echo "Start delete_old_pics Current hours:".date("G")."\n";
	if ( date("G")==0 && (int)date('i')<10 ) listFolderFiles('/var/www/html/oleg/ss/uploads/');


	/*
		if (date("G")==0 ){
		// Удаляем старые фото
			exec('/var/www/html/oleg/ss/1.bat',$output);
			echo("delete_old_pics - DONE CONSOLE SHOW:\n-----------------------\n".$output."\n------------------------------\n");
		}
*/
}
function skipping_task() {

 	$query = "SELECT log_action.id FROM `log_action` left join common_action on common_action.id = task_id left JOIN schedule on sched_id=schedule.id where time_end != '0000-00-00 00:00:00' and sched_id!=0 and (FLOOR((UNIX_TIMESTAMP(time_end)-UNIX_TIMESTAMP(time_start))/60)-schedule.duration)<-1 and UNIX_TIMESTAMP(time_start)>UNIX_TIMESTAMP(CURDATE()) and review=0";
	$result2 = mysql_query($query) or die("Query skipping_task failed:".$query."\n");
	while (list($log_action_id) = mysql_fetch_row($result2)) {
			$query = "update log_action set  review=-1 where id=$log_action_id";
			$result3 = mysql_query($query) or die("Query skipping_task failed:".$query."\n");
	}
	echo("skipping_task - DONE \n");
}
function sched_lowtime() {

 	$query = "SELECT log_action.id FROM `log_action` left join common_action on common_action.id = task_id left JOIN schedule on sched_id=schedule.id where time_end != '0000-00-00 00:00:00' and sched_id!=0 and (FLOOR((UNIX_TIMESTAMP(time_end)-UNIX_TIMESTAMP(time_start))/60)-schedule.duration)<-1 and UNIX_TIMESTAMP(time_start)>UNIX_TIMESTAMP(CURDATE()) and review=0";
	$result2 = mysql_query($query) or die("Query  sched_lowtime failed:".$query." \n");
	while (list($log_action_id) = mysql_fetch_row($result2)) {
		$query = "update log_action set  review=-1 where id=$log_action_id";
		$result3 = mysql_query($query) or die("Query  sched_lowtime failed:".$query." \n");
	}
	echo "sched_lowtime - DONE"."\n";
}

/* It is fail function task_overtime with sql error. Call DISABLED*/
function task_overtime() {

	$query = "SELECT rules.id,log_action.id, payment, hm_times, max 
              FROM `log_action` 
              LEFT  JOIN common_action on common_action.id = task_id 
              LEFT  JOIN violation on log_action.id=log_action_id 
              LEFT  JOIN rules on rule_max=rules.id              
              WHERE 
                 time_end = '0000-00-00 00:00:00' 
                 and sched_id=0 
                 and duration_max>0 
                 and (FLOOR((UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(time_start))/60)-duration_max)>1 
                 and log_action_id IS NULL  ";


	$result2 = mysql_query($query) or die("Query task_overtime");
	while (list($rules_id, $log_action_id, $payment, $hm_times, $max) = mysql_fetch_row($result2)) {
			$money=$payment * $hm_times;
		if ($money>$max) $money=$max;
			$query = "
                      insert INTO violation (rule_id,user_id,date_creation,	money, log_action_id) 
                      values ($rules_id, 10000, now(), $money, $log_action_id)";
			$result3 = mysql_query($query) or die("Query failed33".$query);
		}
echo('Ok');

}

function checkstoppedActions(){
	echo "Start:\tcheckstoppedActions:".date('d/m/Y H:i:s')."\n";
	if((int)date("G")>18) return;

		/* SELECT LAST ACTION FOR EACH USER */
		$sSQL = "select user_id,max(time_start) as sttime 
             from log_action 
			 where `time_start` BETWEEN '" . date("Y-m-d") . " 00:00:00' AND  '" . date("Y-m-d") . " 18:00:00' 
			 GROUP BY user_id";
		/*
         * TEST
         * REQ: select user_id,max(time_start) as sttime
                 from log_action
                 where `time_start` BETWEEN '2016-09-28 00:00:00' AND  '2016-09-28 18:00:00'
                 GROUP BY user_id
           ANSW:
                        user_id		sttime
                        2			2016-09-28 13:32:56
                        4			2016-09-28 12:59:59
                        5			2016-09-28 13:25:51
                        6			2016-09-28 13:25:46
                        7			2016-09-28 13:29:55
                        8			2016-09-28 13:22:33
                        11			2016-09-28 10:31:19

        */


		$rs = mysql_query($sSQL) or die("Query Error:" . $sSQL . "\n");
		while ($r = mysql_fetch_assoc($rs)) {
			//var_dump($r);
			echo $r["user_id"].":".date("Y-m-d H:i:s",time())." - ".date("Y-m-d H:i:s",strtotime($r['sttime']))."orig:".$r['sttime']."|".(time()-strtotime($r['sttime']))."<br/>\n";
			//echo ("(".date("Y-m-d H:i:s",time()).")".time()." - (".date("Y-m-d H:i:s",strtotime($r['sttime'])).")".strtotime($r['sttime'])."=".(time() - strtotime($r['sttime'])) )."\n";*/
			if (time() - strtotime($r['sttime']) >= 180) {
				echo ">180 =>".print_r($r,true)."\n<br />";
				/* Если задаче больше 3 минут - она нам интересна */
				/* Смотрим time_end и одновременно в violation на предмет есть ли уже за текущую дату замечание */
				$sSQL = "select a.id,a.time_end , b.id as violation_id
						 from log_action a
						 Left Join violation b ON
								   b.user_id = a.user_id AND
								   b.`date_creation` BETWEEN '" . date("Y-m-d") . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59' 
						 where a.user_id='" . $r['user_id'] . "' and a.time_start='" . $r['sttime'] . "' Limit 0,1 ";
				/*echo "<hr/>".$sSQL."<hr/>";*/
				$rls = mysql_query($sSQL) or die("Query Error:" . $sSQL . "\n");
				while ($rl = mysql_fetch_assoc($rls)) {
					$longTm = ($rl['time_end']=='0000-00-00 00:00:00' || empty($rl['time_end'])) ? 0 : strtotime($rl['time_end']);
					echo "if (\$rl['time_end'](".$rl['time_end'].") > '0000-00-00 00:00:00' && (time()".time()." - strtotime(\$rl['time_end'])".$longTm.")(".(time() - $longTm ).") >= 180 && ".( (int)date('G',$longTm ) )."<18 && !\$rl['violation_id'](".$rl['violation_id'].")  ) - условие не проходит\n<br/> ";

					/* echo "IF ".$rl['time_end']." > '0000-00-00 00:00:00' && ".(time() - strtotime($rl['time_end']) )." >= 180 && ".$rl['violation_id']."\n"; */
					if ($rl['time_end'] > '0000-00-00 00:00:00' && (time() - $longTm ) >= 180 && (int)date('G',$longTm )<18 && !$rl['violation_id'] ) {
						/* Если задание окончено более трех минут назад и нет замечания за сегодня, то ставим замечание id=1 */
						var_dump($rl);
						echo "UID:".$r['user_id']." - Fault\n";

						$rs_rule = mysql_query(
									   " select id,rule,payment 
										 from rules 
										 where user_id='".$r['user_id']."' 
										  and `rule` like '1.%'  Limit 0,1"
						) or die("Query Error:select id,rule,payment from rules where id='1'\n");

						if($rs_rule) {

							$rs_rule = mysql_fetch_assoc($rs_rule);
							/*var_dump($rs_rule);*/



							$sSQL = "insert into violation 
                            (
									`rule_id`, 
									`user_id`, 
									`date_creation`, 
									`complaint`, 
									`date_paid`, 
									`money`, 
									`log_action_id`
                            )   values	(
								  '".$rs_rule['id']."',
								  '".$r['user_id']."',
								  now(),
								  '',
								  '0000-00-00 00:00:00',
								  '".$rs_rule['payment']."',
								  '".$rl['id']."'
                             ) ";

							mysql_query($sSQL) or die("Query Error:" . $sSQL . "\n");
						}//if($rs_rule) {
					}

				}//while ($rl = mysql_fetch_assoc($rls)) {
			}//if (time() - strtotime($r['sttime']) >= 180) {
		}//while ($r = mysql_fetch_assoc($rs)) {






	/*
	 * NEED REBUILD DATABASE STRUCTURE AND CREATE INDEXES
	 *  THIS SQL DONT USE - SERVER WILL DOWN
	 *
	 *
	 	SELECT a.`time_start`, a.`task_id`, a.`user_id`, a.`sched_id`
		FROM `log_action` a
		WHERE  a.`time_start` BETWEEN '".date("Y-m-d")."' 00:00:00' AND  '".date("Y-m-d")." 18:00:00'  AND a.id = (

					select max(id)
					FROM `log_action` b
					where b.`time_start` BETWEEN '".date("Y-m-d")."' 00:00:00' AND  '".date("Y-m-d")." 18:00:00'
	                      AND b.`user_id`= a.`user_id`

		)
	 */



	echo "End:\tcheckstoppedActions:".date('d/m/Y H:i:s')."\n";
}
	echo "</pre>";

$size=ob_get_length();
if ($size > 0){
	$content = ob_get_contents();
	file_put_contents('/var/www/html/oleg/ss/uploads/cron.log',$content);
}

