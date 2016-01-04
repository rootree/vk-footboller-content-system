<?php
 
define('SYSPATH', '/');
$GLOBALS['runningOn'] = 1;

include("../application/config/config.php");

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


$sql = "SELECT * FROM teams_store WHERE   back_up_id is NULL";

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
	 
	
	$sql = "SELECT * FROM teams_store WHERE   back_up_id = " . $row['tm_id'];

	$resultRR = mysql_query($sql); 
	if (!$resultRR) {
		echo "Could not successfully run query ($sql) from DB: " . mysql_error();
		exit;
	} 
	if (mysql_num_rows($resultRR) != 0) { 

		while ($rowRR = mysql_fetch_assoc($resultRR)) {
		  
				$sql = "UPDATE footballers_store set tm_id = " . $row['tm_id'] . " WHERE   tm_id = " . $rowRR['tm_id'];

				$resultTT = mysql_query($sql);  
		  
				$sql = "UPDATE coaches_store set tm_id = " . $row['tm_id'] . " WHERE   tm_id = " . $rowRR['tm_id'];

				$resultTT = mysql_query($sql);  
 
		}

	}

}
  
  
  
  
  
?>
