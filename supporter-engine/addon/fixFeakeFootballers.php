<?php


define('FOOTBALLER_LINE_FORWARD', '1');
define('FOOTBALLER_LINE_HALFSAFER', '2');
define('FOOTBALLER_LINE_SAFER', '3');
define('FOOTBALLER_LINE_GOALKEEPER', '4');

$conn = mysql_connect("localhost", "root", "111111");

if (!$conn) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}
  
if (!mysql_select_db("football")) {
    echo "Unable to select mydbname: " . mysql_error();
    exit;
}

mysql_query("SET NAMES 'utf8';");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
mysql_query("SET SESSION time_zone = '+3:00';");

$sql = "SELECT * FROM footballers JOIN item_footballers ON item_footballers.id = footballers.footballer_id";

$result = mysql_query($sql);
 $SQL = null;
 
while ($row = mysql_fetch_assoc($result)) {
	  
	 
		$sqlRR = "update footballers set level = " . $row['param_level'] . " where footballer_id  = " . $row['footballer_id'] . "  ;\n\n"; 
		echo ($sqlRR);
 
}
  
 
 
?>