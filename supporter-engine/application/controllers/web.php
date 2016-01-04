<?php defined('SYSPATH') OR die('No direct access allowed.');

set_time_limit(0);

abstract class Web_Controller extends Template_Controller {

    public $template = 'kohana/template';

    const ALLOW_PRODUCTION = FALSE;

    protected $accessRules;

    public function __construct() {

        parent::__construct();

        expires::set(600);

        Kohana::config_set('locale', 'ru_RU');

        $this->input = new Input();
        $this->session = new Session(); // TODO
        $this->db = new Database();

        $this->db->query("SET NAMES 'utf8';");
        $this->db->query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
        $this->db->query("SET SESSION time_zone = '+3:00';");

        $this->selected_page = null;
        $this->selected_subpage = null;
        $this->error = null;
        $this->info = null;
        $this->moderId = 0;

        if($this->session->get("access")){
            $this->access = $this->session->get("access");
            $this->moderId = $this->session->get("moderId");
        }else{
            $this->access = ACCESS_GUEST;
        }

    }

    protected function NL(){
        return "<br/>" . PHP_EOL;
    }

    protected function exec($command){
        if($GLOBALS['runningOn'] == 3){
            pclose(popen($command, 'r'));;
        }else{
            die($command);
        }
    }

    protected function haveAccess(){
        $srcController = debug_backtrace();
        $srcController = $srcController[1]['function'];
        if(!($this->accessRules[$srcController] & $this->access)){
            // нет прав
            $this->template->content = new View('error/access');
            $this->error = 'Ваших прав не достаточно для просмотра этой страницы' . $this->NL();
            return false;
        }else{
            return true;
        }
    }

    protected function haveAccessByStatus($status){
        if(!($GLOBALS['ACCESS_BY_STATUS'][$status] & $this->access)){
            return false;
        }else{
            return true;
        }
    }

    protected function makeCopy($table, $nameOfIdField, $id, $nameOfStatusField){

        $SQLResult = $this->db->select('*')->from($table)->
                where(array($nameOfIdField => $id))->get();

        if($SQLResult->count()){

            $record = $SQLResult->current();

            unset($record->$nameOfIdField);
            $record->$nameOfStatusField = ITEM_STATUS_BACKUP;
            $record->back_up_id = $id;
            $record->action_by = $this->moderId;

            if($record->moder_id != $this->moderId){

                $status = $this->db->insert($table, $this->object2array($record));

            }


        }
    }

    private function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }
}
?>