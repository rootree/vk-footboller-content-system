<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Рассылка сообщений пользователям
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Coaches_Controller extends Web_Controller {

    const SUBPAGE_MAIN    = 'main';
    const SUBPAGE_ADD = 'add';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER ,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'photo' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'add' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'info' => ACCESS_ADMIN + ACCESS_MODER
        );
    }

    public function add() {

        $this->template->content = new View('coaches/add');

        $this->template->title = 'Добавление тренера';
        $this->selected_page    = PAGE_COACHES;
        $this->selected_subpage = Coaches_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };

        $this->template->content->teams = $this->db->select('*')->from('teams_store')
                ->join('cups_store', 'cups_store.cp_id',
            'teams_store.cp_id', ' AND cups_store.back_up_id is null AND cups_store.moder_rating > 0')
                ->where('1=1 and teams_store.back_up_id IS NULL')->orderby('tm_id', 'desc')->get();
        if ($_POST){

            $data['ch_name'] = trim($_POST['footballer']['name']);
            $data['tm_id'] = intval(@$_POST['footballer']['team']);
            $data['ch_photo'] = trim($_POST['footballer']['photo']);
            $data['moder_id'] = $this->moderId;

            $data['ch_status']  = ITEM_STATUS_NEW ;

            if(empty($data['ch_name'])){
                $this->error .= 'Укажите имя тренера' . $this->NL();
            }
  

            if(!$data['tm_id']){
                $this->error .= 'Укажите команду' . $this->NL();
            }

            if(empty($data['ch_photo'])){
                $this->error .= 'Укажите адрес фотографии тренера для анкеты' . $this->NL();
            }elseif(!valid::URL($data['ch_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии для анкеты' . $this->NL();
            }

            if(is_null($this->error)){

                $status = $this->db->insert('coaches_store', $data);

                if(count($status)){
                    $this->info = 'Тренера добавлен.';
                    url::redirect(url::site() . "coaches/info/id/" . $status->insert_id());
                    exit();
                }
            }
        }
    }

    public function edit() {

        $this->template->content = new View('coaches/edit');
        $this->template->title = 'Редактирование тренера';
        $this->selected_page    = PAGE_COACHES;
        $this->selected_subpage = null;
        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();
        $this->template->content->teams = $this->db->select('*')->from('teams_store')
                ->join('cups_store', 'cups_store.cp_id',
            'teams_store.cp_id', ' AND cups_store.back_up_id is null AND cups_store.moder_rating > 0')
                ->where('1=1 and teams_store.back_up_id IS NULL')->orderby('tm_id', 'desc')->get();

        if ($_POST){

            $data['ch_name'] = trim($_POST['footballer']['name']);
            $data['tm_id'] = intval(@$_POST['footballer']['team']);
            $data['ch_photo'] = trim($_POST['footballer']['photo']);
            $data['moder_id'] = $this->moderId;

            $data['ch_status']  = ITEM_STATUS_NEW ;

            if(empty($data['ch_name'])){
                $this->error .= 'Укажите имя тренера' . $this->NL();
            }
 

            if(!$data['tm_id']){
                $this->error .= 'Укажите команду' . $this->NL();
            }

            if(empty($data['ch_photo'])){
                $this->error .= 'Укажите адрес фотографии тренера для анкеты' . $this->NL();
            }elseif(!valid::URL($data['ch_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии для анкеты' . $this->NL();
            }

            if(is_null($this->error)){

                if(!$this->haveAccessByStatus($this->template->content->item->ch_status)){
                    $this->error .= 'Запрещённая операция' . $this->NL();
                }else{
                    $id = intval($this->uri->segment('id'));

                    $this->makeCopy('coaches_store', 'ch_id', $id, 'ch_status');

                    $status = $this->db->update('coaches_store', $data, array('ch_id' => $id));

                    if(count($status)){
                        $this->info = 'Тренер отредактирован.';
                        url::redirect(url::site() . "coaches/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                        exit();
                    }
                }
            }
        }
    }

    public function photo() {

        $this->template->content = new View('coaches/photo');
        $this->template->title = 'Редактирование фотографий';
        $this->selected_page    = PAGE_COACHES;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

        $this->template->content->best = intval($this->uri->segment('best'));

        $srcPhoto = ($this->template->content->best) ? $this->template->content->item->ch_photo_best : $this->template->content->item->ch_photo;
        $this->template->content->srcPhoto = $srcPhoto;

        $size = getimagesize($srcPhoto);
        if(!is_array($size)){
            $this->error .= "Указанное изображение не подходит. Выберите другое изображение." . $this->NL();
            return;
        }

        $this->template->content->size = $size;

        if($this->template->content->best){
            $this->template->content->templateW = IMAGE_BEST_W;
            $this->template->content->templateH = IMAGE_BEST_H;
        }else{
            $this->template->content->templateW = IMAGE_AVATAR_W;
            $this->template->content->templateH = IMAGE_AVATAR_H;
        }

        if ($_POST){

            $coordinates = array(
                'x' => $_POST['x'],
                'y' => $_POST['y'],
                'w' => $_POST['w'],
                'h' => $_POST['h']
            );

            if(empty($coordinates["x"]) && empty($coordinates["w"])){
                $this->error .= "А отмечать кто будет область редактирования" . $this->NL();
                return;
            }

            if(!$this->haveAccessByStatus($this->template->content->item->ch_status)){
                $this->error .= 'Запрещённая операция' . $this->NL();
            }else{
                $zoom = 1;

                $copiedFile = STORE_DISK . '/' . STORE_COACHES . '/' . $this->template->content->item->ch_id . '.jpg';

                $cmd_command = 'convert ' . escapeshellarg($srcPhoto) . '  -quality 75 -compress JPEG -coalesce ' .
                        '-crop "' . ceil($zoom * $coordinates['w']) . 'x' . ceil($zoom * $coordinates['h']) . '+' .
                        ceil($zoom * $coordinates['x']) . '+' . ceil($zoom * $coordinates['y']) . '" '.
                        " -geometry " . $this->template->content->templateW . "x" . $this->template->content->templateH . " +repage " .
                        escapeshellarg($copiedFile);

                $this->exec($cmd_command);

                url::redirect(url::site() . "coaches/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                exit();
            }
        }
    }

    public function index() {

        $this->template->content = new View('coaches/index');

        $this->template->title = 'Список тренеров';
        $this->selected_page    = PAGE_COACHES;
        $this->selected_subpage = Coaches_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $offset = $this->uri->segment('page');

        $page_limit = 25;

        //$base_url = 'products:'.$this->id;
        $table = 'coaches_store';
        $where = '1=1 and coaches_store.back_up_id is null';

 
        $offset = $page_limit * ($offset - 1);
        if(!isset($offset) || $offset <= 0){
            $offset = 1;
        }
        $this->template->content->items = $this->db->select('*')->from($table)->join('teams_store', 'coaches_store.tm_id', 'teams_store.tm_id')->
                where($where)->offset($offset)->limit($page_limit)->orderby('ch_name', 'acs')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
           'base_url'    => 'coaches/index',

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

    public function info() {

        $this->template->content = new View('coaches/info');
        $this->template->title = 'Информация о тренере';
        $this->selected_page    = PAGE_COACHES;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

/*        if ($_POST || $this->uri->segment('updated')){

            switch ($this->template->content->item->ch_status){
                case ITEM_STATUS_NEW:
                case ITEM_STATUS_SENT:
                    $status = $this->db->update('coaches_store', array("ch_status" => ITEM_STATUS_SENT), array('ch_id' => $this->template->content->item->ch_id));
                    if(count($status)){
                        $this->info = 'Тренер проработан';
                        $this->template->content->item->ch_status = ITEM_STATUS_SENT;
                    }
                    break;
                case ITEM_STATUS_IN_GAME:
                case ITEM_STATUS_RECOMMIT:
                    $status = $this->db->update('coaches_store', array("ch_status" => ITEM_STATUS_RECOMMIT), array('ch_id' => $this->template->content->item->ch_id));
                    if(count($status)){
                        $this->info = 'Элемент, используемый в игре, отредактирован';
                        $this->template->content->item->ch_status = ITEM_STATUS_RECOMMIT;
                    }
                    break;
                default:
                    $this->error = 'Ошибочная операция';
                    return;
            }
        }*/
    }

    private function getFootballerInfo($freshId = 0){
 
        $id = intval($this->uri->segment('id'));
        $table = "coaches_store";
        $where = "ch_id = " . $id;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];
    }

} 