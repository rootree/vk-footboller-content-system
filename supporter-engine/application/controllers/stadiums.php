<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Рассылка сообщений пользователям
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Stadiums_Controller extends Web_Controller {

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

        $this->template->content = new View('stadiums/add');

        $this->template->title = 'Добавление стадиона';
        $this->selected_page    = PAGE_STADIUMS;
        $this->selected_subpage = Stadiums_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };

        if ($_POST){

            $data['st_name'] = trim($_POST['footballer']['name']);
            $data['st_city'] = trim($_POST['footballer']['city']);
            $data['st_country_code'] = intval($_POST['footballer']['country']);
            $data['st_level'] = trim(@$_POST['footballer']['level']);
            $data['st_photo'] = trim($_POST['footballer']['photo']);
            $data['moder_id'] = $this->moderId;

            $data['st_status']  = ITEM_STATUS_NEW ;

            if(empty($data['st_name'])){
                $this->error .= 'Укажите название стадиона' . $this->NL();
            }

            if(empty($data['st_city'])){
                $this->error .= 'Укажите город в котором находиться стадион' . $this->NL();
            }

            if(!$data['st_country_code']){
                $this->error .= 'Выбирете принадлежность к стране' . $this->NL();
            }

            if(!$data['st_level']){
                $this->error .= 'Укажите с которого доступен стадион' . $this->NL();
            }

            if(empty($data['st_photo'])){
                $this->error .= 'Укажите адрес фотографии стадиона' . $this->NL();
            }elseif(!valid::URL($data['st_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии стадиона' . $this->NL();
            }


            if(is_null($this->error)){

                $status = $this->db->insert('stadiums_store', $data);

                if(count($status)){
                    $this->info = 'Стадион добавлен.';
                    url::redirect(url::site() . "stadiums/info/id/" . $status->insert_id());
                    exit();
                }
            }
        }
    }

    public function edit() {

        $this->template->content = new View('stadiums/edit');
        $this->template->title = 'Редактирование стадиона';
        $this->selected_page    = PAGE_STADIUMS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

        if ($_POST){

            $data['st_name'] = trim($_POST['footballer']['name']);
            $data['st_city'] = trim($_POST['footballer']['city']);
            $data['st_country_code'] = intval($_POST['footballer']['country']);
            $data['st_level'] = trim(@$_POST['footballer']['level']);
            $data['st_photo'] = trim($_POST['footballer']['photo']);
            $data['moder_id'] = $this->moderId;

            $data['st_status']  = ITEM_STATUS_NEW ;

            if(empty($data['st_name'])){
                $this->error .= 'Укажите название стадиона' . $this->NL();
            }

            if(empty($data['st_city'])){
                $this->error .= 'Укажите город стадиона' . $this->NL();
            }

            if(!$data['st_country_code']){
                $this->error .= 'Выбирете принадлежность к стране' . $this->NL();
            }

            if(!$data['st_level']){
                $this->error .= 'Укажите с которого доступен стадион' . $this->NL();
            }

            if(empty($data['st_photo'])){
                $this->error .= 'Укажите адрес фотографии стадиона' . $this->NL();
            }elseif(!valid::URL($data['st_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии стадиона' . $this->NL();
            }

            if(is_null($this->error)){

                if(!$this->haveAccessByStatus($this->template->content->item->st_status)){
                    $this->error .= 'Запрещённая операция' . $this->NL();
                }else{
                    $id = intval($this->uri->segment('id'));

                    $this->makeCopy('stadiums_store', 'st_id', $id, 'st_status');

                    $status = $this->db->update('stadiums_store', $data, array('st_id' => $id));

                    if(count($status)){
                        $this->info = 'Стадион отредактирован.';
                        url::redirect(url::site() . "stadiums/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                        exit();
                    }
                }
            }
        }
    }

    public function photo() {

        $this->template->content = new View('stadiums/photo');
        $this->template->title = 'Редактирование фотографий';
        $this->selected_page    = PAGE_STADIUMS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

        $this->template->content->best = intval($this->uri->segment('best'));

        $srcPhoto = ($this->template->content->best) ? $this->template->content->item->st_photo_best : $this->template->content->item->st_photo;
        $this->template->content->srcPhoto = $srcPhoto;

        $size = getimagesize($srcPhoto);
        if(!is_array($size)){
            $this->error .= "Указанное изображение не подходит. Выберите другое изображение." . $this->NL();
            return;
        }

        $this->template->content->size = $size;

        $this->template->content->templateW = IMAGE_STADIUM_W;
        $this->template->content->templateH = IMAGE_STADIUM_H;
 
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

            if(!$this->haveAccessByStatus($this->template->content->item->st_status)){
                $this->error .= 'Запрещённая операция' . $this->NL();
            }else{
                //$zoom = round( $size[0] / $this->info['im_copy_wigth'], 4);
                $zoom = 1;

                $copiedFile = STORE_DISK . '/' . STORE_STADIUMS . '/' . $this->template->content->item->st_id . '.jpg';

                $cmd_command = 'convert ' . escapeshellarg($srcPhoto) . '  -quality 75 -compress JPEG -coalesce ' .
                        '-crop "' . ceil($zoom * $coordinates['w']) . 'x' . ceil($zoom * $coordinates['h']) . '+' .
                        ceil($zoom * $coordinates['x']) . '+' . ceil($zoom * $coordinates['y']) . '" '.
                        " -geometry " . $this->template->content->templateW . "x" . $this->template->content->templateH . " +repage " .
                        escapeshellarg($copiedFile);

                $this->exec($cmd_command);

                url::redirect(url::site() . "stadiums/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                exit();
            }
        }
    }

    public function index() {

        $this->template->content = new View('stadiums/index');

        $this->template->title = 'Созданные стадионы';
        $this->selected_page    = PAGE_STADIUMS;
        $this->selected_subpage = Stadiums_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $offset = $this->uri->segment('page');

        $page_limit = 25;

        //$base_url = 'products:'.$this->id;
        $table = 'stadiums_store';
        $where = '1=1 and back_up_id is null';

        if(!isset($offset) || $offset == 0){
            $offset = 1;
        }
        $offset = $page_limit * ($offset - 1);

        $this->template->content->items = $this->db->select('*')->from($table)->
                where($where)->offset($offset)->limit($page_limit)->orderby('st_id', 'city')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'    => 'stadiums/index',

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

        $this->template->content = new View('stadiums/info');
        $this->template->title = 'Информация о стадионе';
        $this->selected_page    = PAGE_STADIUMS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

/*        if ($_POST || $this->uri->segment('updated')){

            switch ($this->template->content->item->st_status){
                case ITEM_STATUS_NEW:
                case ITEM_STATUS_SENT:
                    $status = $this->db->update('stadiums_store', array("st_status" => ITEM_STATUS_SENT), array('st_id' => $this->template->content->item->st_id));
                    if(count($status)){
                        $this->info = 'Футболист проработан';
                        $this->template->content->item->st_status = ITEM_STATUS_SENT;
                    }
                    break;
                case ITEM_STATUS_IN_GAME:
                case ITEM_STATUS_RECOMMIT:
                    $status = $this->db->update('stadiums_store', array("st_status" => ITEM_STATUS_RECOMMIT), array('st_id' => $this->template->content->item->st_id));
                    if(count($status)){
                        $this->info = 'Элемент, используемый в игре, отредактирован';
                        $this->template->content->item->st_status = ITEM_STATUS_RECOMMIT;
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
        $table = "stadiums_store";
        $where = "st_id = " . $id;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];
    }

} 