<?php

 

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

$cups = array(
'Чемпионат Франции. 3-й дивизион',
'Чемпионат Украины. 1-я лига',
'Чемпионат России. 1-й дивизион',
'Чемпионат Италии. Серия "Б"',
'Чемпионат Испании. 2-й дивизион',
'Чемпионат Англии. Чемпион-Лига',
'Чемпионат России. Премьер-Лига',
'Чемпионат Франции',
'Чемпионат Англии. Премьер-Лига'
);

$sql = "SELECT * FROM cups_store WHERE moder_rating > 0 AND  back_up_id is NULL";

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
$count = 1;
while ($row = mysql_fetch_assoc($result)) {

	if(in_array($row['cp_name'], $cups)){
			
		 echo "\n";
			
			$count  ++ ;

			$sql = "SELECT * FROM teams_store WHERE cp_id = " . $row['cp_id'] . "  AND  back_up_id is NULL order by tm_rating desc limit 5";

			$resultQ = mysql_query($sql);

			if (!$resultQ) {
				echo "Could not successfully run query ($sql) from DB: " . mysql_error();
				exit;
			}

			if (mysql_num_rows($resultQ) == 0) {
				echo "No rows found, nothing to print so am exiting";
				exit;
			}

			// While a row of data exists, put that row in $row as an associative array
			// Note: If you're expecting just one row, no need to use a loop
			// Note: If you put extract($row); inside the following loop, you'll
			//       then create $userid, $fullname, and $userstatus

			$collectLevel = array();

			while ($rowQ = mysql_fetch_assoc($resultQ)) {
 
				echo $rowQ['tm_name'] . " (" . $row['cp_name'] . ") - уровень " . $row['cp_level'] . " \n";
		 
			 }
 
 
 
	}else{
	//	echo "Не нашли - " . $row['cp_name'] .  " \n";
	} 
	
  
 }

?>
