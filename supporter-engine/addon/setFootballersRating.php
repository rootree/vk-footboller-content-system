<?php


$conn = mysql_connect("localhost", "root", "111111");


if (!$conn) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}

$DB = mysql_select_db("webnizer_footballer");


mysql_query("SET NAMES 'utf8';");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
mysql_query("SET SESSION time_zone = '+3:00';");

$sql = "SELECT * FROM coaches_store ";

$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {
    $ch_rating = rand(1, 5);
    $sql = "update coaches_store set ch_rating = $ch_rating where ch_id = " . $row['ch_id'];
    mysql_db_query("webnizer_footballer", $sql);
}








$sql = "SELECT * FROM teams_store ;";

$resultWW = mysql_db_query("webnizer_footballer", $sql);
if (!$resultWW) {
    die('Invalid query: ' . mysql_error());
}

while ($row = mysql_fetch_assoc($resultWW)) {

    $sql = "SELECT * FROM footballers_store where tm_id = " . $row['tm_id'];

    $resultEE = mysql_db_query("webnizer_footballer", $sql);
    if (!$resultEE) {
        die('Invalid query: ' . mysql_error());
    }

    if(mysql_num_rows($resultEE) < 11){
 
        $sql = "update teams_store set tm_status = 0 where tm_id = " . $row['tm_id'];

        $resultGGsdas= mysql_db_query("webnizer_footballer", $sql);
        if (!$resultGGsdas) {
            die('Invalid query: ' . mysql_error());
        }

        echo "continue\n";
        continue;
    }

    $ratingTeam = array();

    while ($rowRR = mysql_fetch_assoc($resultEE)) {

        $sql = "select count(footballer_id) from footballers where footballer_id = " . $rowRR['ft_id'];

        $resultGG = mysql_db_query("535698_football", $sql);
        if (!$resultGG) {
            die('Invalid query: ' . mysql_error());
        }
        if(mysql_num_rows($resultEE) == 0){

            $sql = "update footballers_store set ft_rating = " . rand(1, 5) . " where tm_id = " . $rowRR['ft_id'];

            echo "rating: " . $rowRR['ft_id'] . " - " . rand(1, 5) . "\n";

            $resultGGsd= mysql_db_query("webnizer_footballer", $sql);
            if (!$resultGGsd) {
                die('Invalid query: ' . mysql_error());
            }
            continue;
        }

        $ratingTeam[$rowRR['ft_id']] = mysql_result($resultGG,0,0);

    }

    if(count($ratingTeam)){
        $mmax =  max($ratingTeam);


        foreach($ratingTeam as $id => $rat){

            if(empty($rat) || empty($mmax)){
                $matchRR = rand(1, 5);;
            }else{
                $matchRR = ceil ( $rat * 5 / $mmax );
            }

            $sql = "update footballers_store set ft_rating = " . $matchRR . " where ft_id = " . $id;

            $resultEE = mysql_db_query("webnizer_footballer",$sql);
            if (!$resultEE) {
                die('Invalid query: ' . mysql_error());
            }
        }
    }


}


?>
