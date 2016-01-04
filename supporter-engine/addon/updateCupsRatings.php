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

$sql = "SELECT * FROM cups_store WHERE   cp_id in (

50023, 50081, 50017, 50011, 50053, 50091, 50009, 50026, 50088, 50083, 50066, 50074, 50078, 50069, 50067
)";

$result = mysql_query($sql);

if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

if (mysql_num_rows($result) == 0) {
    echo "No rows found, nothing to print so am exiting";
    exit;
}

// While a row of data exists, put that row in $row as an associative array
// Note: If you're expecting just one row, no need to use a loop
// Note: If you put extract($row); inside the following loop, you'll
//       then create $userid, $fullname, and $userstatus

$collectLevel = array();
$ratingTeam = array();

while ($row = mysql_fetch_assoc($result)) {
 
    $ratingTeam[$row['cp_id']] = $row['moder_rating'];

}
 
asort($ratingTeam);
 
$count = 1;
 foreach($ratingTeam as $id => $rat){

    $sql = "update cups_store set cp_level = " . $count . " where cp_id = " . $id;
    $resultEE = mysql_db_query("webnizer_footballer",$sql);
    if (!$resultEE) {
        die('Invalid query: ' . mysql_error());
    }
     $count++;
}

mysql_free_result($result);

 
?>
