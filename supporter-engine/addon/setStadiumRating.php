<?php

 

$conn = mysql_connect("localhost", "root", "111111");

if (!$conn) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}
  
if (!mysql_select_db("webnizer_footballer")) {
    echo "Unable to select mydbname: " . mysql_error();
    exit;
}
mysql_query("SET NAMES 'utf8';");
    mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
    mysql_query("SET SESSION time_zone = '+3:00';");
 
$sql = "SELECT * FROM stadiums_store ";

$result = mysql_query($sql);
  
while ($row = mysql_fetch_assoc($result)) { 
	$ch_rating = rand(1, 5);
	$sql = "update stadiums_store set st_rating = $ch_rating where st_id = " . $row['st_id'];
	mysql_query($sql); 
}
  

?>
