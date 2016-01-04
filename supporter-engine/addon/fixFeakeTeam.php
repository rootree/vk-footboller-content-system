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

$sql = "SELECT * FROM teams WHERE date_reg is NULL";

$result = mysql_query($sql);
 
 $SQL = null;
 
while ($row = mysql_fetch_assoc($result)) {
	  
		$param_forward  = 0;
		$param_half  = 0;
		$param_safe = 0;
	 
		$SQLTemp = NULL;
		
		$sqlRR = "SELECT * FROM footballers 
		JOIN item_footballers ON item_footballers.id = footballers.footballer_id
		WHERE owner_vk_id = " . $row['vk_id'] . "  "; 
		$resultRR = mysql_query($sqlRR);
	
		while ($rowRR = mysql_fetch_assoc($resultRR)) {

			switch($rowRR['line']){
				case FOOTBALLER_LINE_FORWARD:
					$param_forward += $rowRR['level'];
					break;
				case FOOTBALLER_LINE_SAFER:
				case FOOTBALLER_LINE_GOALKEEPER:
					$param_safe += $rowRR['level']; 
					break;
				case FOOTBALLER_LINE_HALFSAFER:
					$param_half += $rowRR['level']; 
					break;
			} 
		} 
 
		$SQL .= "
update teams set 
    param_forward = " . $param_forward. ",
    param_half = " . $param_half . ",
    param_safe = " . $param_safe . "
    where vk_id = " . $row['vk_id'] . " ;

" ;

	 $SQLTemp  = null;

}
 


echo $SQL;
 
 
?>