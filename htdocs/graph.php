<?php   

#error_reporting(E_ALL); // For debug
error_reporting(0);
 
defined('SYSPATH') or define('SYSPATH', 'NEED');
defined('APPPATH') or define('APPPATH', 'NEED');

define('DIR_ENGINE', '../../engine');
define('DIR_PCHART', DIR_ENGINE. '/application/libraries/pChart');
define('DIR_FONT', DIR_PCHART . '/Fonts');
define('DIR_CACHE', DIR_PCHART . '/Cache');

if(!class_exists('Template_Controller')) {
    class Template_Controller {
    }
}

try {
    include(DIR_ENGINE . '/system/config/database.php') ; 
} catch(Exception $e) {
    echo '#Error: ' .$e->getMessage();
}
 
define('GRAPH_TYPE_AU', 1);
define('GRAPH_TYPE_ACTIVE_REG', 2);
define('GRAPH_TYPE_REG', 3);

// Standard inclusions      
include(DIR_PCHART . "/pData.class");
include(DIR_PCHART . "/pChart.class");

$statistic_DB = 'stuff';

$conn = pg_connect("host=" . $config[$statistic_DB]['connection']['host'] . 
	" port=" .$config[$statistic_DB]['connection']['port'] . 
	" dbname=" . $config[$statistic_DB]['connection']['database'] . 
	" user=" . $config[$statistic_DB]['connection']['user'] . 
	" password=" . $config[$statistic_DB]['connection']['pass']);

if (!$conn) {
    echo 'Не подключились к БД :(';
}

function prepareData($scaleX, $scaleY, $SQL, $scaleType) {

    global $conn;

    $DataSet = new pData;

    $result = pg_query($conn, $SQL);
    if (!$result) {
        echo "An error occured.\n";
    }

    while ($row = pg_fetch_row($result)) {

        $DataSet->AddPoint($row[1], "Serie2");
        $DataSet->AddPoint(mktime(0, 0, 0, substr($row[0],5,2), substr($row[0],8,2), substr($row[0],0,4)), "Serie1");
        
    }

    $DataSet->SetAbsciseLabelSerie("Serie1");
    $DataSet->AddSerie("Serie2");

    $DataSet->SetYAxisName($scaleY);
    $DataSet->SetXAxisFormat($scaleType);
 
    return $DataSet;
    
}


/**
 * Генерация графика
 * @param DataSet $DataSet
 * @param String $GraphTitle
 * @param String $safeToFile
 */
function createGraphToFile($DataSet, $GraphTitle, $safeToFile, $scaleFormat) {

    // Rotrate
    $rotate = 30;



    // Initialise the graph
    $GraphImage = new pChart(594,344);

    $GraphImage->setDateFormat($scaleFormat);
    // $GraphImage->loadColorPalette(DIR_FONT.'/tones-3.txt');
    
    $GraphImage->setFontProperties(DIR_FONT . "/segoepr.ttf",8);
    $GraphImage->setGraphArea(80,50,580,300);
    $GraphImage->drawFilledRectangle(3,3,590,340,240,240,240);
    $GraphImage->drawRectangle(0,0,593,343,230,230,230);
    $GraphImage->drawGraphArea(255,255,255,TRUE);
    $GraphImage->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_START0,150,150,150,TRUE,$rotate,0,FALSE);
    $GraphImage->drawGrid(4,TRUE,230,230,230,50);

    // Draw the 0 line
    $GraphImage->setFontProperties(DIR_FONT . "/segoepr.ttf",6);
    $GraphImage->drawTreshold(0,143,55,72,TRUE,TRUE);   // Просто пунктирная линия

    // Draw the cubic curve graph
    $GraphImage->drawCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription());

    // Draw the line graph
    //$GraphImage->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
    $GraphImage->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);



    // Finish the graph
    $GraphImage->setFontProperties(DIR_FONT . "/segoepr.ttf",12);
    $GraphImage->drawTitle(60,32,$GraphTitle,50,50,50,600);
    
    //$GraphImage->Render(DIR_CACHE . './' . $safeToFile . '.png');
    $GraphImage->Stroke();

}

$scaleType = 'date';
$scaleFormat = 'd.m.Y';

switch ($_GET['graph_type']) {
    
    case 1:
        $scaleY = "Пользователи";
        $scaleX = "Дни";
        $SQL = "SELECT au_date, au_count FROM cs_active_users WHERE au_type = " . GRAPH_TYPE_AU ;
        $safeToFile = 'test';
        $GraphTitle = "Daily Active Users";
        break;
    case 2:
        $scaleY = "Пользователи";
        $scaleX = "Дни";
        $SQL = "SELECT au_date, au_count FROM cs_active_users WHERE au_type = " . GRAPH_TYPE_ACTIVE_REG ;
        $safeToFile = 'test';
        $GraphTitle = "Количество активных пользователй в день";
        break;
    case 3:
        $scaleY = "Пользователи";
        $scaleX = "Дни";
        $SQL = "SELECT au_date, au_count FROM cs_active_users WHERE au_type = " . GRAPH_TYPE_REG ;
        $safeToFile = 'test';
        $GraphTitle = "Количество регистраций";
        break;
    case 4:
        $scaleY = "Пользователи";
        $scaleX = "Месяцы";
        $SQL = "SELECT au_date, au_count FROM cs_active_users WHERE au_type = " . GRAPH_TYPE_AU ;
        $safeToFile = 'test';
        $GraphTitle = "Month Active Users";
        $scaleFormat = 'm.Y';
        break;
        
    case 5:
        $scaleY = "Пользователи";
        $scaleX = "По 10 минут";
        $SQL = "SELECT ou_datetime, ou_count FROM cs_online_users";
        $safeToFile = 'test';
        $GraphTitle = "Количество пользователей онлайн";
        //$scaleType = 'time';
        $scaleFormat = 'H:m';
        break;
    
    case 6:
        $scaleY = "Голоса";
        $scaleX = "Часы";
        $SQL = "SELECT pm_date, pm_money FROM cs_payments";
        $safeToFile = 'test';
        $GraphTitle = "Платежи по часам";
        //$scaleType = 'time';
        $scaleFormat = 'h:m';
        break;

    case 7:
        $scaleY = "Голоса";
        $scaleX = "Дни";
        $SQL = "SELECT pm_date, pm_money FROM cs_payments";
        $safeToFile = 'test';
        $GraphTitle = "Платежи по дням";
        break;
}

$DataSet = prepareData($scaleX, $scaleY, $SQL, $scaleType);
 
createGraphToFile($DataSet, $GraphTitle, $safeToFile, $scaleFormat);

?>