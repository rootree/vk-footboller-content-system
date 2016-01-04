<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Рассылка сообщений пользователям
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Sponsors_Controller extends Web_Controller {

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

        $this->template->content = new View('sponsors/add');

        $this->template->title = 'Добавление спонсора';
        $this->selected_page    = PAGE_SPONSORS;
        $this->selected_subpage = Sponsors_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $data['sp_name'] = trim($_POST['footballer']['name']);
            $data['sp_level'] = trim(@$_POST['footballer']['level']);
            $data['sp_rating'] = trim(@$_POST['footballer']['rating']);
            $data['sp_photo'] = trim($_POST['footballer']['photo']);
            $data['moder_id'] = $this->moderId;

            $data['sp_status']  = ITEM_STATUS_NEW ;

            if(empty($data['sp_name'])){
                $this->error .= 'Укажите название спонсора' . $this->NL();
            }

            if(!$data['sp_level']){
                $this->error .= 'Укажите уровень' . $this->NL();
            }

            if(!$data['sp_rating']){
                $this->error .= 'Укажите рейтинг' . $this->NL();
            }

            if(empty($data['sp_photo'])){
                $this->error .= 'Укажите адрес фотографии спонсора для анкеты' . $this->NL();
            }elseif(!valid::URL($data['sp_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии' . $this->NL();
            }

            if(is_null($this->error)){

                $status = $this->db->insert('sponsors_store', $data);

                if(count($status)){
                    $this->info = 'Спонсор добавлен.';
                    url::redirect(url::site() . "sponsors/info/id/" . $status->insert_id());
                    exit();
                }
            }
        }
    }

    public function edit() {

        $this->template->content = new View('sponsors/edit');
        $this->template->title = 'Редактирование спонсора';
        $this->selected_page    = PAGE_SPONSORS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

        if ($_POST){

            $data['sp_name'] = trim($_POST['footballer']['name']);
            $data['sp_level'] = trim(@$_POST['footballer']['level']);
            $data['sp_rating'] = trim(@$_POST['footballer']['rating']);
            $data['sp_photo'] = trim($_POST['footballer']['photo']);
            $data['moder_id'] = $this->moderId;

            $data['sp_status']  = ITEM_STATUS_NEW ;

            if(empty($data['sp_name'])){
                $this->error .= 'Укажите имя игрока' . $this->NL();
            }

            if(!$data['sp_level']){
                $this->error .= 'Укажите уровень' . $this->NL();
            }

            if(!$data['sp_rating']){
                $this->error .= 'Укажите рейтинг' . $this->NL();
            }
/*
            if(empty($data['sp_photo'])){
                $this->error .= 'Укажите адрес фотографии игрока для анкеты' . $this->NL();
            }elseif(!valid::URL($data['sp_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии для анкеты' . $this->NL();
            }*/

            if(is_null($this->error)){

                if(!$this->haveAccessByStatus($this->template->content->item->sp_status)){
                    $this->error .= 'Запрещённая операция' . $this->NL();
                }else{
                    $id = intval($this->uri->segment('id'));

                    $this->makeCopy('sponsors_store', 'sp_id', $id, 'sp_status');

                    $status = $this->db->update('sponsors_store', $data, array('sp_id' => $id));

                    if(count($status)){
                        $this->info = 'Спонсор отредактирован.';
                        url::redirect(url::site() . "sponsors/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                        exit();
                    }
                }
            }
        }
    }

    public function photo() {

        $this->template->content = new View('sponsors/photo');
        $this->template->title = 'Редактирование фотографий';
        $this->selected_page    = PAGE_SPONSORS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

        $this->template->content->best = intval($this->uri->segment('best'));

        $srcPhoto = ($this->template->content->best) ? $this->template->content->item->sp_photo_best : $this->template->content->item->sp_photo;
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

            if(!$this->haveAccessByStatus($this->template->content->item->sp_status)){
                $this->error .= 'Запрещённая операция' . $this->NL();
            }else{
                $zoom = 1;

                $copiedFile = STORE_DISK . '/' . STORE_SPONSORS . '/' . $this->template->content->item->sp_id . '.jpg';

                $cmd_command = 'convert ' . escapeshellarg($srcPhoto) . '  -quality 75 -compress JPEG -coalesce ' .
                        '-crop "' . ceil($zoom * $coordinates['w']) . 'x' . ceil($zoom * $coordinates['h']) . '+' .
                        ceil($zoom * $coordinates['x']) . '+' . ceil($zoom * $coordinates['y']) . '" '.
                        " -geometry " . $this->template->content->templateW . "x" . $this->template->content->templateH . " +repage " .
                        escapeshellarg($copiedFile);

                $this->exec($cmd_command);

                url::redirect(url::site() . "sponsors/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                exit();
            }
        }
    }

    public function index() {

        $this->template->content = new View('sponsors/index');

        $this->template->title = 'Созданные спонсоры';
        $this->selected_page    = PAGE_SPONSORS;
        $this->selected_subpage = Sponsors_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $offset = $this->uri->segment('page');

        $page_limit = 25;

        //$base_url = 'products:'.$this->id;
        $table = 'sponsors_store';
        $where = '1=1 and back_up_id is null';

        if(!isset($offset) || $offset == 0){
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('sp_id', 'desc')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'    => 'sponsors/index',

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

        $this->template->content = new View('sponsors/info');
        $this->template->title = 'Информация о спонсоре';
        $this->selected_page    = PAGE_SPONSORS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

/*        if ($_POST || $this->uri->segment('updated')){

            switch ($this->template->content->item->sp_status){
                case ITEM_STATUS_NEW:
                case ITEM_STATUS_SENT:
                    $status = $this->db->update('sponsors_store', array("sp_status" => ITEM_STATUS_SENT), array('sp_id' => $this->template->content->item->sp_id));
                    if(count($status)){
                        $this->info = 'Спонсор проработан';
                        $this->template->content->item->sp_status = ITEM_STATUS_SENT;
                    }
                    break;
                case ITEM_STATUS_IN_GAME:
                case ITEM_STATUS_RECOMMIT:
                    $status = $this->db->update('sponsors_store', array("sp_status" => ITEM_STATUS_RECOMMIT), array('sp_id' => $this->template->content->item->sp_id));
                    if(count($status)){
                        $this->info = 'Элемент, используемый в игре, отредактирован';
                        $this->template->content->item->sp_status = ITEM_STATUS_RECOMMIT;
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
        $table = "sponsors_store";
        $where = "sp_id = " . $id;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];
    }

} 