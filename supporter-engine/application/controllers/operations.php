<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Рассылка сообщений пользователям
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Operations_Controller extends Web_Controller {

    const SUBPAGE_MAIN    = 'main';
    const SUBPAGE_UPDATES = 'updates';
    const SUBPAGE_HISTORY = 'history';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN ,
            'updates' => ACCESS_ADMIN ,
        );

    }

    public function updates() {

        include(PATH_ENGINE . "/addon/checkTeamComplete.php");
        include(PATH_ENGINE . "/addon/checkCupsComplete.php");

        $this->template->content = new View('operations/updates');

        $this->template->title = 'Обновление прогресса';
        $this->selected_page    = PAGE_OPERATIONS;
        $this->selected_subpage = Operations_Controller::SUBPAGE_UPDATES;

    }


    public function index() {

        $this->template->content = new View('operations/index');

        $this->template->title = 'Доступные операции';
        $this->selected_page    = PAGE_OPERATIONS;
        $this->selected_subpage = Operations_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            ini_set('memory_limit', '128M');
            ini_set('max_input_time', '600');
            ini_set('max_execution_time', '600');

            $db_pro = new Database('pro');

            $db_pro->query("SET NAMES 'utf8';");
            $db_pro->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
            $db_pro->query("SET SESSION time_zone = '+3:00';");

/*

               $footballersStore = $this->db->select('*')->from("footballers_store")->
                    orderby(array( "ft_rating" => "asc", "ft_name" =>  "asc"))->
                    where("tm_id = 41626")->get();

            $this->info .=  "Обработано Футболистов: " . $footballersStore->count() . $this->NL();


                $orderby = 1;
                foreach($footballersStore as $footballer) {


                    $footballer->ft_level = 6;
 

                    $price = misc::getPrice($footballer->ft_level, $footballer->ft_rating);
                    $multi = misc::getFootbollerMultiplay($footballer->ft_level, $footballer->ft_rating);
 
echo "ft_rating: " . $footballer->ft_rating . " - price1: " . $price[0] . " price2: " . $price[1] . " - multi " . $multi . "<br/>";
                    
                }

exit();

*/


            $fh = fopen(ITEMS_XML, 'w') or die("can't open file");

            $XML =
                    '<?xml version="1.0" encoding="UTF-8"?>
<its>';

            fwrite($fh, $this->trimNewLine($XML));

            $stadiumsStore = $this->db->select('*')->from("stadiums_store")->
                    orderby(array("st_level" => "asc", "st_name" => "asc") )->
                    where("stadiums_store.back_up_id is null and st_status in (" . ITEM_STATUS_SENT . "," . ITEM_STATUS_NEW . "," . ITEM_STATUS_RECOMMIT .  ")")->get();

            $this->info .=  "Обработано стадионов: " . $stadiumsStore->count() . $this->NL();

            if($stadiumsStore->count()){

                $XML = PHP_EOL . "<!-- Cтадионы -->" . PHP_EOL;
                fwrite($fh, $this->trimNewLine($XML));

                $orderby = 1;
                foreach($stadiumsStore as $stadium) {

                    $sourceFile = STORE_DISK . '/' . STORE_STADIUMS . '/' . $stadium->st_id . '.jpg';
                    if(!file_exists($sourceFile)){
                        continue;
                    }

                    $price = misc::getStadiumPrice($stadium->st_level, $stadium->st_rating);  
                    $multi = misc::getStadiumMultiplay($stadium->st_level, $stadium->st_rating);
 

                    $XML =
                            '    <it id="' . $stadium->st_id . '">
        <orb>' . $orderby . '</orb>
        <cln>SimpleStadium</cln>
        <st>Stadium</st>
        <reql>' . $stadium->st_level . '</reql>
        <pr>' . $price[0] . '</pr>
        <rlpr>' . $price[1] . '</rlpr>
        <prm>
            <city>' . $this->stripE($stadium->st_city) . '</city>
            <tytle>' . $this->stripE($stadium->st_name) . '</tytle>
            <ccode>' . $stadium->st_country_code . '</ccode>
            <daily>' . $multi . '</daily>
            <rating>' . $stadium->st_rating . '</rating>
        </prm>
    </it>PHP_EOL' . PHP_EOL;
                    fwrite($fh, $this->trimNewLine($XML));


                    $SQL =
                            "
INSERT INTO item_stadiums (id, required_level, price, real_price, day_bonus)
VALUES (" . $stadium->st_id . ", " . $stadium->st_level . ", " . $price[0] . ", ". $price[1] . " , ". $multi . ")
ON DUPLICATE KEY
UPDATE
    required_level = " . $stadium->st_level . ",
    price = " . $price[0] . ",
    real_price = " . $price[1] . ",
    day_bonus = " . $multi . "
";
                    $db_pro->query($SQL);
 
                    $status = $this->db->update('stadiums_store', array("st_status" => ITEM_STATUS_NEW), array('st_id' => $stadium->st_id));

                    $gameFile = STORE_GAME . '/' . STORE_GAME_STADIUMS . '/' . $stadium->st_id . '.jpg';
                    if(file_exists($gameFile) && filesize($gameFile) != filesize($sourceFile)){
                        copy($sourceFile, $gameFile);
                    }elseif(!file_exists($gameFile)){
                        copy($sourceFile, $gameFile);
                    }

                    $orderby++;

                }
            }

            $sponsorsStore = $this->db->select('*')->from("sponsors_store")->
                    orderby(array("sp_level" => "asc", "sp_rating" => "asc", "sp_name" => "asc")) ->
                    where("sponsors_store.back_up_id is null and sp_status in (" . ITEM_STATUS_SENT . "," . ITEM_STATUS_NEW . "," . ITEM_STATUS_RECOMMIT .  ")")->get();

            if($sponsorsStore->count()){

                $XML = PHP_EOL . "<!-- Спонсоры -->" . PHP_EOL;
                fwrite($fh, $this->trimNewLine($XML));

                $orderby = 1;
                $this->info .=  "Обработано спонсоров: " . $sponsorsStore->count() . $this->NL();
                foreach($sponsorsStore as $sponsor) {

                    $sourceFile = STORE_DISK . '/' . STORE_SPONSORS . '/' . $sponsor->sp_id . '.jpg';
                    if(!file_exists($sourceFile) || empty($sponsor->sp_level)){ // TODO
                        continue;
                    }

                    $energy = misc::getEnegry($sponsor->sp_level, $sponsor->sp_rating);

                    $XML =
                            '    <it id="' . $sponsor->sp_id . '">
        <orb>' . $orderby . '</orb>
        <nm>' . $this->stripE($sponsor->sp_name) . '</nm>
        <cln>SimpleSponsor</cln> 
        <reql>' . $sponsor->sp_level . '</reql>
        <st>Sponsor</st>
        <prm>
            <energy>' . $energy . '</energy>
        </prm>
    </it>PHP_EOL' . PHP_EOL;
                    fwrite($fh, $this->trimNewLine($XML));

                    $SQL =
                            "
INSERT INTO item_sponsors (id, required_level, energy) VALUES (" . $sponsor->sp_id . ", " . $sponsor->sp_level . ", $energy)
ON DUPLICATE KEY UPDATE required_level = " . $sponsor->sp_level . ", energy = " . $energy . "
";
                    $db_pro->query($SQL);

                    $status = $this->db->update('sponsors_store', array("sp_status" => ITEM_STATUS_NEW), array('sp_id' => $sponsor->sp_id));


                    $gameFile = STORE_GAME . '/' . STORE_GAME_SPONSORS . '/' . $sponsor->sp_id . '.jpg';

                    if(file_exists($gameFile) && filesize($gameFile) != filesize($sourceFile)){
                        copy($sourceFile, $gameFile);
                    }elseif(!file_exists($gameFile)){
                        copy($sourceFile, $gameFile);
                    }

                    $orderby++;
                }
            }




            $cupsStore = $this->db->select('*')->from("cups_store")->// orderby("tm_level, tm_rating", "asc")->
                    //where("cups_store.back_up_id is null and cp_status in (" . ITEM_STATUS_SENT . "," . ITEM_STATUS_NEW . "," . ITEM_STATUS_RECOMMIT .  ")")->get();
                    where("cp_id in (

50023, 50081, 50017, 50011, 50053, 50091, 50009, 50026, 50088, 50083, 50066, 50074, 50078, 50069, 50067
)")->get();

            $this->info .=  "Обработано чемпионатов: " . $cupsStore->count() . $this->NL();


            $cupsStoreFile = array();

            if($cupsStore->count()){
                foreach($cupsStore as $cup) {
                    $cupsStoreFile[$cup->cp_id] = $cup; 
                }
            }


            $cupsID = array();


            $teamsStore = $this->db->select('*')->from("teams_store")->
                    join('cups_store', 'cups_store.cp_id', 'teams_store.cp_id')->
                    orderby(array("cp_level" => "asc", "tm_rating" => "asc") )->
                    where("teams_store.back_up_id is null and tm_status in (" . ITEM_STATUS_SENT . "," . ITEM_STATUS_NEW . "," . ITEM_STATUS_RECOMMIT .  ")")->
                    get();

            $this->info .=  "Обработано команд: " . $teamsStore->count() . $this->NL();

            $teamStoreFile = array();

            if($teamsStore->count()){

                $XML = PHP_EOL . "<!-- Команды -->" . PHP_EOL;
                fwrite($fh, $this->trimNewLine($XML));

                $orderby = 1;
                foreach($teamsStore as $teams) {

                    if(!isset($cupsStoreFile[$teams->cp_id])){
                        continue;
                    }

                    $teamStoreFile[$teams->tm_id] = $teams;

                    $sourceFile = STORE_DISK . '/' . STORE_TEAMS . '/' . $teams->tm_id . '.jpg';
                    if(!file_exists($sourceFile)){
                        continue;
                    }

                    $cupsID[$teams->cp_id] = 1;

                    $XML =
                            '   <it id="' . $teams->tm_id . '">
        <orb>' . $orderby . '</orb>
        <cln>SimpleTeam</cln>
        <nm>' . $this->stripE($teams->tm_name) . '</nm>
        <st>Team</st>
        <prm>
            <level>' . $teams->cp_level . '</level>
            <cup>' . $teams->cp_id . '</cup>
        </prm>
    </it>PHP_EOL' . PHP_EOL;
                    fwrite($fh, $this->trimNewLine($XML));

                    $status = $this->db->update('teams_store', array("tm_status" => ITEM_STATUS_NEW), array('tm_id' => $teams->tm_id));

                    $gameFile = STORE_GAME . '/' . STORE_GAME_TEAMS . '/' . $teams->tm_id . '.jpg';


                    if(file_exists($gameFile) && filesize($gameFile) != filesize($sourceFile)){
                        copy($sourceFile, $gameFile);
                    }elseif(!file_exists($gameFile)){
                        copy($sourceFile, $gameFile);
                    }
                    $orderby++;
                }
            }






            $cupsStore = $this->db->select('*')->from("cups_store")->// orderby("tm_level, tm_rating", "asc")->
                    where("cp_id in (

50023, 50081, 50017, 50011, 50053, 50091, 50009, 50026, 50088, 50083, 50066, 50074, 50078, 50069, 50067
)")->get();
                    //where("cups_store.back_up_id is null and cp_status in (" . ITEM_STATUS_SENT . "," . ITEM_STATUS_NEW . "," . ITEM_STATUS_RECOMMIT .  ")")->get();

            $this->info .=  "Обработано чемпионатов: " . $cupsStore->count() . $this->NL();


            if( $cupsStore->count()){

                $XML = PHP_EOL . "<!-- Чепионаты -->" . PHP_EOL;
                fwrite($fh, $this->trimNewLine($XML));

                $orderby = 1;
                foreach($cupsStore as $cup) {

                    if(!array_key_exists($cup->cp_id, $cupsID)){
                        continue;
                    }
 
                    $XML =
                            '   <it id="' . $cup->cp_id . '">
        <orb>' . $orderby . '</orb>
        <cln>SimpleCup</cln>
        <nm>' . $cup->cp_name . '</nm>
        <reql>' . $cup->cp_level . '</reql>
        <prm>
            <ccode>' . $cup->cp_country_code . '</ccode>
        </prm>
    </it>PHP_EOL' . PHP_EOL;
                    fwrite($fh, $this->trimNewLine($XML));

                    $status = $this->db->update('cups_store', array("cp_status" => ITEM_STATUS_NEW), array('cp_id' => $cup->cp_id));

                    $orderby++;
                }
            }

 
            $footballersStore = $this->db->select('*')->from("footballers_store")->
                    orderby(array( "ft_rating" => "asc", "ft_name" =>  "asc"))->
                    where("footballers_store.back_up_id is null and ft_status in (" . ITEM_STATUS_SENT . "," . ITEM_STATUS_NEW . "," . ITEM_STATUS_RECOMMIT . ")")->get();
                 //   where("tm_id = 42362")->get();

            $this->info .=  "Обработано Футболистов: " . $footballersStore->count() . $this->NL();

            if($footballersStore->count()){

                $XML = PHP_EOL . "<!-- Футболисты -->" . PHP_EOL;
                fwrite($fh, $this->trimNewLine($XML));

                $orderby = 1;
                foreach($footballersStore as $footballer) {

                    if(!isset($teamStoreFile[$footballer->tm_id])){
                        continue;
                    }

                    $footballer->ft_level = $teamStoreFile[$footballer->tm_id]->cp_level;

                    $sourceFileBest = STORE_DISK . '/' . STORE_BEST . '/' . $footballer->ft_id . '.jpg';
                    $sourceFile = STORE_DISK . '/' . STORE_AVATARS . '/' . $footballer->ft_id . '.jpg';

                    if(!file_exists($sourceFile) || !file_exists($sourceFileBest)){
                        continue;
                    }

                    $price = misc::getPrice($footballer->ft_level, $footballer->ft_rating);

print_r($price);
                    echo "<br/>" . $footballer->ft_level . " - " . $footballer->ft_rating . "<br/>";

                    $multi = misc::getFootbollerMultiplay($footballer->ft_level, $footballer->ft_rating);
                    $XML =
                            '  <it id="' . $footballer->ft_id . '">
        <orb>' . $orderby . '</orb>
        <his>0</his>
        <nm>' . $this->stripE($footballer->ft_name) . '</nm> 
        <pr>' . $price[0] . '</pr>
        <rlpr>' . $price[1] . '</rlpr>
        <reql>' . $footballer->ft_level . '</reql>
        <cln>SimpleFootballer</cln>
        <st>' . $this->getStringStatus($footballer->ft_line) . '</st>
        <prm>
            <level>' . $multi . '</level>
            <team>' . $footballer->tm_id . '</team>
            <year>' . $footballer->ft_year . '</year>
        </prm>
    </it>PHP_EOL' . PHP_EOL;
                    fwrite($fh, $this->trimNewLine($XML));

                    $SQL =
                            "
INSERT INTO item_footballers (id, required_level, price, real_price, param_level, line)
VALUES (" . $footballer->ft_id . ", " . $footballer->ft_level . ", " . $price[0] . ", ". $price[1] . " , ". $multi . ", " . $footballer->ft_line . ")
ON DUPLICATE KEY
UPDATE
    required_level = " . $footballer->ft_level . ",
    price = " . $price[0] . ",
    real_price = " . $price[1] . ",
    param_level = " . $multi . ",
    line = " . $footballer->ft_line . "
";
                    $db_pro->query($SQL);

                    $status = $this->db->update('footballers_store', array("ft_status" => ITEM_STATUS_NEW), array('ft_id' => $footballer->ft_id));

                    $gameFile = STORE_GAME . '/' . STORE_GAME_AVATARS . '/' . $footballer->ft_id . '.jpg';
                    if(file_exists($gameFile) && filesize($gameFile) != filesize($sourceFile)){
                        copy($sourceFile, $gameFile);
                    }elseif(!file_exists($gameFile)){
                        copy($sourceFile, $gameFile);
                    }



                    $gameFile = STORE_GAME . '/' . STORE_GAME_BEST . '/' . $footballer->ft_id . '.jpg';
                    if(file_exists($gameFile) && filesize($gameFile) != filesize($sourceFileBest)){
                        copy($sourceFileBest, $gameFile);
                    }elseif(!file_exists($gameFile)){
                        copy($sourceFileBest, $gameFile);
                    }
                    $orderby++;

                }
            }


//exit();

            $coachesStore = $this->db->select('*')->from("coaches_store")->
                    orderby(array(  "ch_rating" => "asc", "ch_name" => "asc" ))->
                    where("coaches_store.back_up_id is null and ch_status in (" . ITEM_STATUS_NEW . "," . ITEM_STATUS_NEW . "," . ITEM_STATUS_RECOMMIT . ")")->get();

            $this->info .= "Обработано тренеров: " . $coachesStore->count() . $this->NL();

            if($coachesStore->count()){

                $XML = PHP_EOL . "<!-- Тренера -->" . PHP_EOL;
                fwrite($fh, $this->trimNewLine($XML));

                $orderby = 1;
                foreach($coachesStore as $coach) {

                    $sourceFile = STORE_DISK . '/' . STORE_COACHES . '/' . $coach->ch_id . '.jpg';
                    if(!file_exists($sourceFile)){
                        continue;
                    }

                    if(!isset($teamStoreFile[$coach->tm_id])){
                        continue;
                    }

                    $coach->ch_level = $teamStoreFile[$coach->tm_id]->cp_level;;
                    $price = misc::getPriceCoach($coach->ch_level, $coach->ch_rating);
                    $multi = misc::getCoachMultiplay($coach->ch_level, $coach->ch_rating);

                    $XML =
                            '    <it id="' . $coach->ch_id . '">
        <orb>' . $orderby . '</orb>
        <his>0</his>
        <nm>' . $this->stripE($coach->ch_name) . '</nm>
        <pr>'. $price[0] . '</pr>
        <rlpr>'. $price[1] . '</rlpr>
        <reql>' . $coach->ch_level . '</reql>
        <cln>SimpleFootballer</cln>
        <st>teamlead</st>
        <prm>
            <studyRate>'. $multi . '</studyRate>
            <team>' . $coach->tm_id . '</team>
        </prm>
    </it>PHP_EOL' . PHP_EOL;
                    fwrite($fh, $this->trimNewLine($XML));

                    if($coach->ch_status == ITEM_STATUS_SENT){
                        $status = $db_pro->insert('item_teamleads', array(
                            "id" => $coach->ch_id,
                            "required_level" => $coach->ch_level,
                            "price" => $price[0],
                            "real_price" => $price[1],
                            "param_study_rate" => $multi,
                        ));
                    }else{
                        $status = $db_pro->update('item_teamleads', array(
                            "required_level" => $coach->ch_level,
                            "price" => $price[0],
                            "real_price" => $price[1],
                            "param_study_rate" => $multi,
                        ), array('id' => $coach->ch_id));
                    }

                    $SQL =
                            "
INSERT INTO item_teamleads (id, required_level, price, real_price, param_study_rate)
VALUES (" . $coach->ch_id . ", " . $coach->ch_level . ", " . $price[0] . ", ". $price[1] . " , ". $multi . ")
ON DUPLICATE KEY
UPDATE
    required_level = " . $coach->ch_level . ",
    price = " . $price[0] . ",
    real_price = " . $price[1] . ",
    param_study_rate = " . $multi . "
";
                    $db_pro->query($SQL);



                    $status = $this->db->update('coaches_store', array("ch_status" => ITEM_STATUS_NEW), array('ch_id' => $coach->ch_id));

                    $gameFile = STORE_GAME . '/' . STORE_GAME_COACHES . '/' . $coach->ch_id . '.jpg';

                    if(file_exists($gameFile) && filesize($gameFile) != filesize($sourceFile)){
                        copy($sourceFile, $gameFile);
                    }elseif(!file_exists($gameFile)){
                        copy($sourceFile, $gameFile);
                    }


                    $orderby++;
                }
            }

            $XML = "</its>";
            fwrite($fh, $this->trimNewLine($XML));

            fclose($fh);

        }
    }

    private function trimNewLine($string){
        $string = str_replace(array("  ", "\t", "\n", "\r", "\0", "\x0B"), "", $string);
        return str_replace("PHP_EOL", "\n", $string);
    }

    private function getStringStatus($status){
        switch ($status){
            case FOOTBALLER_LINE_FORWARD: return "forward";
            case FOOTBALLER_LINE_HALFSAFER: return "halfsafe";
            case FOOTBALLER_LINE_SAFER: return "safe";
            case FOOTBALLER_LINE_GOALKEEPER: return "goalkeeper";
        }
    }
    private function stripE($string){
        $string = str_replace("ё", "е", $string);
        $string = str_replace("Ё", "Е", $string);
        return $string;
    }
} 