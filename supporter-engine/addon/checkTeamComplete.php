<?php
/** 
 * User: Administrator
 * Date: Apr 25, 2010
 * Time: 1:55:05 PM
 *

поиск по командам

ищем тренера
проверяем его фотку

ищем 11 футболичтов
проверяем их фотки

 * @version 1.0
 * @author Ivan Chura <ivan.chura@gmail.com>  
 */

defined('SYSPATH') OR define('SYSPATH', '/');
$GLOBALS['runningOn'] = 3;

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

$sql = "SELECT * FROM teams_store WHERE back_up_id is NULL"; 

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

	$sql = "SELECT * FROM footballers_store WHERE back_up_id is NULL AND tm_id = " . $row['tm_id'];

	$resultRR = mysql_query($sql);
	if (!$resultRR) {
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	}

    $complete['footballer'] = array();

	if (mysql_num_rows($resultRR) != 0) {
        $count = 1;
		while ($rowRR = mysql_fetch_assoc($resultRR)) {

            $complete['footballer'][$count] = 0;

			if(file_exists(STORE_DISK . '/' . STORE_AVATARS . '/' . $rowRR['ft_id'] . '.jpg')) {
                $complete['footballer'][$count] ++;
            }
            
            if(file_exists(STORE_DISK . '/' . STORE_BEST. '/' . $rowRR['ft_id'] . '.jpg')) {
                $complete['footballer'][$count] ++;
            }
            $count ++;
		}
	}

	$sql = "SELECT * FROM coaches_store WHERE back_up_id is NULL AND tm_id = " . $row['tm_id'];

	$resultVV = mysql_query($sql);
	if (!$resultVV) {
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	}

    $complete['coaches'] = 0;

	if (mysql_num_rows($resultVV) != 0) {

        $rowVV = mysql_fetch_assoc($resultVV);

        $complete['coaches'] = 1;

        if(file_exists(STORE_DISK . '/' . STORE_COACHES . '/' . $rowVV['ch_id'] . '.jpg')) {
            $complete['coaches'] ++;
        } 
    }

    $complete['photo'] = 0;
    if(file_exists(STORE_DISK . '/' . STORE_TEAMS . '/' . $row['tm_id'] . '.jpg')) {
        $complete['photo'] = 1;
    }
    
    $team_is_full = 0;

    if($complete['coaches'] > 0 || array_sum($complete['footballer']) > 0 ){
        $team_is_full = 1;
    }
    if($complete['coaches'] == 2 && array_sum($complete['footballer']) >= 22 && $complete['photo'] == 1){
        $team_is_full = 2;
    }
 

    $sql = "UPDATE teams_store SET tm_complete = $team_is_full WHERE tm_id = " . $row['tm_id'];

    $resultSS = mysql_query($sql);
    if (!$resultSS) {
        echo "Could not successfully run query ($sql) from DB: " . mysql_error();
        exit;
    }

}
  
?>