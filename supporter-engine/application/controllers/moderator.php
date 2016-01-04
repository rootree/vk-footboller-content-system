<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Рассылка сообщений пользователям
 *
 * @package    Notify
 * @author     Ivan Chura
 */

define("SECRET_KEY", "FUZ");

class Moderator_Controller extends Web_Controller {

    const SUBPAGE_MAIN    = 'main';
    const SUBPAGE_LOG    = 'log';
    const SUBPAGE_NOTIFY    = 'notify';
    const SUBPAGE_HISTORY    = 'history';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_VIEWER,
            'log' => ACCESS_ADMIN + ACCESS_VIEWER,
            'notify' => ACCESS_ADMIN,
            'history' => ACCESS_ADMIN + ACCESS_VIEWER,
        );

    }
 
    public function log() {

        $this->template->content = new View('moderator/log');

        $this->template->title = 'Действия пользователей';
        $this->selected_page    = PAGE_MODER;
        $this->selected_subpage = Moderator_Controller::SUBPAGE_LOG;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $userId = intval($_POST['userId']);
            if(empty($userId)){
                $this->error .= 'Укажите ID пользователя, о котором собираетесь получить информацию' . $this->NL();
            }

            $userId       = intval($_POST["userId"]);
            $authKey      = md5(SECRET_KEY . $userId . SECRET_KEY);
            $checkSum     = md5($authKey . SECRET_KEY . $userId);

            $urlForCheck = SERVER_GAME . "userInfo.php?userId=" . $userId . "&authKey=" . $authKey . "&checkSum=" . $checkSum;

            $info = file_get_contents($urlForCheck);
            $this->template->title = 'Действия пользователя с ID ' . $userId;

            if(!$info){
                $this->error .= 'Информация о пользователе с указаным ID не найдена' . $this->NL();
            }

            $doc = new DOMDocument();
            $doc->loadXML( $info );

            $team = $doc->getElementsByTagName( "team" );
            $this->template->content->team = json_decode($team->item(0)->nodeValue);

            $this->template->content->requests = $doc->getElementsByTagName( "request" );
        }
    }


    public function index() {

        $this->template->content = new View('moderator/index');

        $this->template->title = 'Информация о пользователях';
        $this->selected_page    = PAGE_MODER;
        $this->selected_subpage = Moderator_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $userId = intval($_POST['userId']);
            if(empty($userId)){
                $this->error .= 'Укажите ID пользователя, о котором собираетесь получить информацию' . $this->NL();
            }

            $userId       = intval($_POST["userId"]);
            $authKey      = md5(SECRET_KEY . $userId . SECRET_KEY);
            $checkSum     = md5($authKey . SECRET_KEY . $userId);

            $urlForCheck = SERVER_GAME . "userInfo.php?userId=" . $userId . "&authKey=" . $authKey . "&checkSum=" . $checkSum . "&onlyProfile";
  
            $info = file_get_contents($urlForCheck);
            $this->template->title = 'Информация о пользователе с ID ' . $userId;

            if(!$info){
                $this->error .= 'Информация о пользователе с указаным ID не найдена' . $this->NL();  
            }

            $doc = new DOMDocument();
            $doc->loadXML( $info );

            $team = $doc->getElementsByTagName( "team" );
            $this->template->content->team = json_decode($team->item(0)->nodeValue);

        }
    }

    public function notify() {

        $this->template->content = new View('moderator/notify');

        $this->template->title = 'Рассылка уведомлений';
        $this->selected_page    = PAGE_MODER;
        $this->selected_subpage = Moderator_Controller::SUBPAGE_NOTIFY;
		$this->error = null;

        if ($_POST){

            $data['notify_message'] = trim($_POST['messageForSend']);;
            $data['notify_status']  = NOTIFY_STATUS_NEW ;
            $data['project_id']     = 1 ;
            $data['notify_date']    = date('Y-m-d H:i:s') ;

            if(empty($data['notify_message'])){
                $this->error = 'Укажите текст рассылки.';
            }

            if(strlen($data['notify_message']) > 1024 || strlen($data['notify_message']) < 3){
                $this->error = 'Масимальное число символов доступных для отправки составляет 1024,<br/> а минимум 4.';
            }

            if(is_null($this->error)){

                $userId       = intval(1);
                $authKey      = md5(SECRET_KEY . $userId . SECRET_KEY);
                $checkSum     = md5($authKey . SECRET_KEY . $userId);
                $command     = "COMAND_ADD";

                $urlForRequest = SERVER_GAME . "historyGate.php?userId=" . $userId . "&authKey=" . $authKey . "&checkSum=" . $checkSum .
                    "&command=" . $command . "&message=" . urlencode($data['notify_message']);
 
                $info = json_decode(file_get_contents($urlForRequest)); 

                if(isset($info->error)){
                    $this->error .= 'Информация о рассылке не добавлена' . $this->NL();
                    $this->error .= $info->error . $this->NL();
                }else{
                    $this->info .= 'Рассылка создана и будет исполнена в ближайшее время.' . $this->NL();
                    $data['notify_id'] = $info->notify_id;
                    
                    $status = $this->db->insert('notify', $data);
                    if(count($status)){
                        $this->info .= 'Рассылка добавлена в базу.' . $this->NL();
                    }
                    
                    $this->history();

                }
            }
        } 
    }
 
    public function history() {

        $this->template->content = new View('moderator/history');

        $this->template->title = 'История рассылок';
        $this->selected_page    = PAGE_MODER;
        $this->selected_subpage = Moderator_Controller::SUBPAGE_HISTORY;

        $offset = $this->uri->segment('page');

        $page_limit = 20;

        $table = 'notify';
        $where = '1=1';

        if(!isset($offset) || $offset == 0){
                $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*')->from($table)->
            where($where)->offset($offset)->limit($page_limit)->orderby('notify_id', 'desc')->get();

        $count_records = $this->db->from($table)->
            where($where)->count_records();

        $pagination = new Pagination(array(
                // Base_url will default to the current URI
                //'base_url'    => $base_url.'/page',

                // The URI segment (integer) in which the pagination number can be found
                // The URI segment (string) that precedes the pagination number (aka "label")
                'uri_segment'    => 'page',

                // You could also use the query string for pagination instead of the URI segments
                // Just set this to the $_GET key that contains the page number
                // 'query_string'   => 'page',

                // The total items to paginate through (probably need to use a database COUNT query here)
                'total_items'    => $count_records,

                // The amount of items you want to display per page
                'items_per_page' => $page_limit,

                // The pagination style: classic (default), digg, extended or punbb
                // Easily add your own styles to views/pagination and point to the view name here
                'style'          => 'digg',

                // If there is only one page, completely hide all pagination elements
                // Pagination->render() will return an empty string
                'auto_hide'      => TRUE,
        ));


        $this->template->content->pagination = $pagination->render('digg');
        $this->template->content->count_records = $count_records;
        $this->template->content->current_first_item = $pagination->current_first_item;


    }

    
}