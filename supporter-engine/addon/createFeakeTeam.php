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
  
if (!mysql_select_db("webnizer_footballer")) {
    echo "Unable to select mydbname: " . mysql_error();
    exit;
}

mysql_query("SET NAMES 'utf8';");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
mysql_query("SET SESSION time_zone = '+3:00';");

$sql = "SELECT * FROM cups_store WHERE moder_rating > 0 AND  back_up_id is NULL";

$result = mysql_query($sql);
 
 $SQL = null;
 
while ($row = mysql_fetch_assoc($result)) {
	 
	$sqlR = "SELECT * FROM teams_store 
	
 join coaches_store on coaches_store.tm_id = teams_store.tm_id

	WHERE teams_store.cp_id = " . $row['cp_id'] . " AND  teams_store.back_up_id is NULL  ";

	$resultR = mysql_query($sqlR);
	 
	while ($rowR = mysql_fetch_assoc($resultR)) {

		$param_forward  = 0;
		$param_half  = 0;
		$param_safe = 0;
	
		$count = 0;
		$SQLTemp = NULL;
		$sqlRR = "SELECT * FROM footballers_store WHERE tm_id = " . $rowR['tm_id'] . " AND  back_up_id is NULL LIMIT 11";

		$resultRR = mysql_query($sqlRR);
		 
		while ($rowRR = mysql_fetch_assoc($resultRR)) {
				
				$count ++;
				
				$multi = getFootbollerMultiplay($rowRR['ft_level'], $rowRR['ft_rating'] ) ;
				
			   $SQLTemp .= 
"INSERT INTO footballers (
    `footballer_id`,
    `owner_vk_id`,
    `level`,
    `is_active`,
    `price`
) VALUES (
    " . $rowRR['ft_id'] . ",
    " . $rowR['tm_id'] . ", 
    " . $multi . ", 
    1,  
    0
);

";
 
			switch($rowRR['ft_line']){
				case FOOTBALLER_LINE_FORWARD:
					$param_forward += $rowRR['ft_line'];
					break;
				case FOOTBALLER_LINE_SAFER:
				case FOOTBALLER_LINE_GOALKEEPER:
					$param_safe += $rowRR['ft_line']; 
					break;
				case FOOTBALLER_LINE_HALFSAFER:
					$param_half += $rowRR['ft_line']; 
					break;
			} 
		} 
		
		if($count == 11){
		 
		$SQL .= "
INSERT INTO teams (
    vk_id,
    team_name,
    team_logo_id, 
      
    able_to_choose,
    trainer_id,
	
    param_forward,
    param_half,
    param_safe 
  
) VALUES (
	" . $rowR['tm_id'] . ",
	'" . stripE($rowR['tm_name']) . "',
	" . $rowR['tm_id'] . ",
	1,
	
	" . $rowR['ch_id'] . ",
	
	" . $param_forward. ",
	
	" . $param_half . ",
	" . $param_safe . "
);

" .  $SQLTemp ;

	 $SQLTemp  = null;

}
 
	} 
}


echo $SQL;

       $footbollersGrid = array(
        /* �������  =>  �� ������� ������ ����� �������� ���*/
        1 => array(1, 0.01),
        2 => array(4, 0.02),
        3 => array(8, 0.03),
        4 => array(16, 0.04),
        5 => array(20, 0.05),
        6 => array(24, 0.06),
        7 => array(28, 0.07),
        8 => array(32, 0.08),
        9 => array(36, 0.09),
        10 => array(40, 0.10)
    );

function getFootbollerMultiplay($level, $rating){
	  global  $footbollersGrid;
        return floor($footbollersGrid[$level][0] + $rating);
    }

function stripE($string){
$string = str_replace("ё", "е", $string);
$string = str_replace("Ё", "Е", $string);
        return $string;
    }
	
 
?>