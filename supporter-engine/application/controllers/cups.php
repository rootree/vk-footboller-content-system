<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Рассылка сообщений пользователям
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Cups_Controller extends Web_Controller {

    const SUBPAGE_MAIN    = 'main';
    const SUBPAGE_ADD = 'add';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER ,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'photo' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'add' => ACCESS_ADMIN + ACCESS_MODER ,
            'info' => ACCESS_ADMIN + ACCESS_MODER
        );

    }

    public function add() {

        $this->template->content = new View('cups/add');

        $this->template->title = 'Добавление стадиона';
        $this->selected_page    = PAGE_CUPS;
        $this->selected_subpage = cups_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $data['cp_name'] = trim($_POST['footballer']['name']);
            $data['cp_country_code'] = intval($_POST['footballer']['country']); 
            $data['moder_rating'] = trim(@$_POST['footballer']['moder_rating']);
            $data['cp_used'] = intval(@$_POST['footballer']['used']);
            $data['moder_id'] = $this->moderId;

            $data['cp_status']  = ITEM_STATUS_NEW ;

            if(empty($data['cp_name'])){
                $this->error .= 'Укажите название стадиона' . $this->NL();
            }

            if(!$data['cp_country_code']){
                $this->error .= 'Выбирете принадлежность к стране' . $this->NL();
            }
 

            if(is_null($this->error)){

                $status = $this->db->insert('cups_store', $data);

                if(count($status)){
                    $this->info = 'Стадион добавлен.';
                    url::redirect(url::site() . "cups/info/id/" . $status->insert_id());
                    exit();
                }
            }
        }
    }

    public function edit() {

        $this->template->content = new View('cups/edit');
        $this->template->title = 'Редактирование стадиона';
        $this->selected_page    = PAGE_CUPS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

        if ($_POST){

            $data['cp_name'] = trim($_POST['footballer']['name']);
            $data['cp_country_code'] = intval($_POST['footballer']['country']);
            $data['moder_rating'] = trim(@$_POST['footballer']['moder_rating']); 
            $data['cp_used'] = trim(@$_POST['footballer']['used']);
            $data['moder_id'] = $this->moderId;

            $data['cp_status']  = ITEM_STATUS_NEW ;

            if(empty($data['cp_name'])){
                $this->error .= 'Укажите название стадиона' . $this->NL();
            }


            if(!$data['cp_country_code']){
                $this->error .= 'Выбирете принадлежность к стране' . $this->NL();
            }

 
            if(is_null($this->error)){

                if(!$this->haveAccessByStatus($this->template->content->item->cp_status)){
                    $this->error .= 'Запрещённая операция' . $this->NL();
                }else{
                    $id = intval($this->uri->segment('id'));

                    $this->makeCopy('cups_store', 'cp_id', $id, 'cp_status');

                    $status = $this->db->update('cups_store', $data, array('cp_id' => $id));

                    if(count($status)){
                        $this->info = 'Стадион отредактирован.';

                    url::redirect(url::site() . "cups/index");
                        url::redirect(url::site() . "cups/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                        exit();
                    }
                }
            }
        }
    }
 

    public function index() {

        $this->template->content = new View('cups/index');

        $this->template->title = 'Созданные стадионы';
        $this->selected_page    = PAGE_CUPS;
        $this->selected_subpage = cups_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $offset = $this->uri->segment('page');

        $page_limit = 25;

        //$base_url = 'products:'.$this->id;
        $table = 'cups_store';
        $where = '1=1 and back_up_id is null';

        if(!isset($offset) || $offset == 0){
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('cp_name')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'    => '/cups/index',

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
        $this->template->content->current_fircp_item = $pagination->current_first_item;
    }

    public function info() {

        $this->template->content = new View('cups/info');
        $this->template->title = 'Информация о стадионе';
        $this->selected_page    = PAGE_CUPS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

/*        if ($_POST || $this->uri->segment('updated')){

            switch ($this->template->content->item->cp_status){
                case ITEM_STATUS_NEW:
                case ITEM_STATUS_SENT:
                    $status = $this->db->update('cups_store', array("cp_status" => ITEM_STATUS_SENT), array('cp_id' => $this->template->content->item->cp_id));
                    if(count($status)){
                        $this->info = 'Футболист проработан';
                        $this->template->content->item->cp_status = ITEM_STATUS_SENT;
                    }
                    break;
                case ITEM_STATUS_IN_GAME:
                case ITEM_STATUS_RECOMMIT:
                    $status = $this->db->update('cups_store', array("cp_status" => ITEM_STATUS_RECOMMIT), array('cp_id' => $this->template->content->item->cp_id));
                    if(count($status)){
                        $this->info = 'Элемент, используемый в игре, отредактирован';
                        $this->template->content->item->cp_status = ITEM_STATUS_RECOMMIT;
                    }
                    break;
                default:
                    $this->error = 'Ошибочная операция';
                    return;
            }
        }*/
    }

    private function getFootballerInfo($freshId = 0){
        /* if($freshId){
            $id = intval($this->uri->segment('id'));
        }else{
            $id = $freshId;
        }*/
        $id = intval($this->uri->segment('id'));
        $table = "cups_store";
        $where = "cp_id = " . $id;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];

 
        $SQL =

"SELECT `teams_store`.tm_name, `teams_store`.tm_id, `teams_store`.tm_status,  `teams_store`.tm_complete,  
`coaches_store`.ch_name, `coaches_store`.ch_id,
`teams_store`.`tm_id` as tm_id,

(SELECT COUNT(`footballers_store`.`ft_id`) FROM `footballers_store` WHERE `footballers_store`.`tm_id` = `teams_store`.`tm_id` AND  footballers_store.back_up_id IS NULL) AS footballers_count

FROM (`teams_store`) 
LEFT JOIN `coaches_store` ON (`coaches_store`.`tm_id` = `teams_store`.`tm_id` AND  coaches_store.back_up_id IS NULL)
WHERE 1=1 AND teams_store.back_up_id IS NULL and cp_id = " . $id . "
";

        $this->template->content->footballers = $this->db->query($SQL);

    }

} 