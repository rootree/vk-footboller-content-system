<?php
/** 
 * User: Administrator
 * Date: Apr 25, 2010
 * Time: 1:55:05 PM
 *
 * поиск по чемпионатам

ищем команды
проверяем их заполнение
проверяем логотипы команд
 * 
 * @version 1.0
 * @author Ivan Chura <ivan.chura@gmail.com>  
 */


defined('SYSPATH') OR define('SYSPATH', '/');
$GLOBALS['runningOn'] = 1;

$configFile = "../application/config/config.php";
file_exists($configFile) AND include_once("../application/config/config.php");

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS);

if (!$conn) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}

if (!mysql_select_db(DB_NAME)) {
    echo "Unable to select mydbname: " . mysql_error();
    exit;
}
mysql_query("SET NAMES 'utf8';");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
mysql_query("SET SESSION time_zone = '+3:00';");

$sql = "SELECT * FROM cups_store WHERE back_up_id is NULL";

$result = mysql_query($sql);
if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

if (mysql_num_rows($result) == 0) {
    echo "No rows found, nothing to print so am exiting";
    exit;
}

$collectLevel = array();

while ($row = mysql_fetch_assoc($result)) {

    $complete = array();

	$sql = "SELECT * FROM teams_store WHERE back_up_id is NULL AND cp_id = " . $row['cp_id'];

	$resultRR = mysql_query($sql);
	if (!$resultRR) {
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	}

    $countComplete = 0;

	if (mysql_num_rows($resultRR) != 0) {

        $count = 0;

		while ($rowRR = mysql_fetch_assoc($resultRR)) {

            if($rowRR['tm_complete'] == 2){
                $countComplete ++;
                $countComplete ++;
            }
            if($rowRR['tm_complete'] == 1){
                $countComplete ++;
            }

            $count ++;
            $count ++;
		}
	}

    if($count && $countComplete){
        $team_is_full = $countComplete * 100 / $count;
    }else{
        $team_is_full = 0;
    }

    $sql = "UPDATE cups_store SET cp_complete = $team_is_full WHERE cp_id = " . $row['cp_id'];

    $resultSS = mysql_query($sql);
    if (!$resultSS) {
        echo "Could not successfully run query ($sql) from DB: " . mysql_error();
        exit;
    }

}


?>
