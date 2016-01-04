<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Рассылка сообщений пользователям
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Footballers_Controller extends Web_Controller {

    const SUBPAGE_MAIN = 'main';
    const SUBPAGE_ADD = 'add';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'photo' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'add' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'info' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER
        );

    }

    public function add() {

        $this->template->content = new View('footballers/add');

        $this->template->title = 'Добавление игрока';
        $this->selected_page    = PAGE_FOOTBALLERS;
        $this->selected_subpage = Footballers_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };

/*
        $this->template->content->champ = $this->db->select('*')->from('cups_store')->
                where('1=1 AND back_up_id is null AND moder_rating > 0')->orderby('cp_name', 'asc')->get();
*/

        $this->template->content->teams = $this->db->select('*')->from('teams_store')
                ->join('cups_store', 'cups_store.cp_id',
            'teams_store.cp_id', ' AND cups_store.back_up_id is null AND cups_store.moder_rating > 0')
                ->where('1=1 and teams_store.back_up_id IS NULL')->orderby('tm_id', 'desc')->get();

        if ($_POST){

            $data['ft_name'] = trim($_POST['footballer']['name']);
            // $data['ft_desc'] = trim($_POST['footballer']['desc']);
            $data['tm_id'] = intval($_POST['footballer']['team']);
            $data['ft_line'] = intval(@$_POST['footballer']['line']);
            $data['tm_id'] = intval(@$_POST['footballer']['team']);
           // $data['ft_rating'] = trim(@$_POST['footballer']['rating']);
            $data['ft_photo'] = trim($_POST['footballer']['photo']);
            $data['ft_photo_best'] = trim($_POST['footballer']['photo_best']);
            $data['ft_year'] = intval($_POST['footballer']['year']);
            $data['moder_id'] = $this->moderId;

            $data['ft_status']  = ITEM_STATUS_NEW ;

            if(empty($data['ft_name'])){
                $this->error .= 'Укажите имя игрока' . $this->NL();
            }

            if($data['ft_year'] > 2000 || $data['ft_year'] < 1940){
                $this->error .= 'Укажите год рождения, с коректным годом (четырёх значное число)' . $this->NL();
            }
/*
            if(empty($data['ft_desc'])){
                $this->error .= 'Укажите описание' . $this->NL();
            }
*/

            if(!$data['ft_line']){
                $this->error .= 'Укажите амплуа' . $this->NL();
            }

/*            if(!$data['ft_level']){
                $this->error .= 'Укажите уровень' . $this->NL();
            }*/

 

            if(!$data['tm_id']){
                $this->error .= 'Укажите команду' . $this->NL();
            }

            if(empty($data['ft_photo'])){
                $this->error .= 'Укажите адрес фотографии игрока для анкеты' . $this->NL();
            }elseif(!valid::URL($data['ft_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии для анкеты' . $this->NL();
            }

            if(empty($data['ft_photo_best'])){
                $this->error .= 'Укажите адрес лучшей фотографии игрока' . $this->NL();
            }elseif(!valid::URL($data['ft_photo_best'])){
                $this->error .= 'Укажите правильный адрес лучшей фотографии' . $this->NL();
            }

            if(is_null($this->error)){

                $status = $this->db->insert('footballers_store', $data);

                if(count($status)){
                    $this->info = 'Футболист добавлен.';
                    url::redirect(url::site() . "footballers/info/id/" . $status->insert_id());
                    exit();
                }
            }
        }
    }

    public function edit() {

        $this->template->content = new View('footballers/edit');
        $this->template->title = 'Редактирование футболиста';
        $this->selected_page    = PAGE_FOOTBALLERS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };
        
        $this->template->content->teams = $this->db->select('*')->from('teams_store')
                ->join('cups_store', 'cups_store.cp_id',
            'teams_store.cp_id', ' AND cups_store.back_up_id is null AND cups_store.moder_rating > 0')
                ->where('1=1 and teams_store.back_up_id IS NULL')->orderby('tm_id', 'desc')->get();

        $this->getFootballerInfo();

        if ($_POST){

            $data['ft_name'] = trim($_POST['footballer']['name']);
          //  $data['ft_desc'] = trim($_POST['footballer']['desc']);
            $data['tm_id'] = intval(@$_POST['footballer']['team']);
            $data['ft_line'] = intval(@$_POST['footballer']['line']);
         //   $data['ft_level'] = trim(@$_POST['footballer']['level']);
          //  $data['ft_rating'] = trim(@$_POST['footballer']['rating']);
            $data['ft_photo'] = trim($_POST['footballer']['photo']);
            $data['ft_photo_best'] = trim($_POST['footballer']['photo_best']);
            $data['ft_year'] = intval($_POST['footballer']['year']);
            $data['moder_id'] = $this->moderId;

            $data['ft_status']  = ITEM_STATUS_NEW ;

            if(empty($data['ft_name'])){
                $this->error .= 'Укажите имя игрока' . $this->NL();
            }
/*
            if(empty($data['ft_desc'])){
                $this->error .= 'Укажите описание' . $this->NL();
            }*/

            if(!$data['ft_line']){
                $this->error .= 'Укажите амплуа' . $this->NL();
            }

            if($data['ft_year'] > 2000 || $data['ft_year'] < 1940){
                $this->error .= 'Укажите год рождения, с коректным годом (четырёх значное число)' . $this->NL();
            }
/*
            if(!$data['ft_level']){
                $this->error .= 'Укажите уровень' . $this->NL();
            }

            if(!$data['ft_rating']){
                $this->error .= 'Укажите рейтинг' . $this->NL();
            }*/


            if(!$data['tm_id']){
                $this->error .= 'Укажите команду' . $this->NL();
            }
            
            if(empty($data['ft_photo'])){
                $this->error .= 'Укажите адрес фотографии игрока для анкеты' . $this->NL();
            }elseif(!valid::URL($data['ft_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии для анкеты' . $this->NL();
            }

            if(empty($data['ft_photo_best'])){
                $this->error .= 'Укажите адрес лучшей фотографии игрока' . $this->NL();
            }elseif(!valid::URL($data['ft_photo_best'])){
                $this->error .= 'Укажите правильный адрес лучшей фотографии' . $this->NL();
            }

            if(is_null($this->error)){

                if(!$this->haveAccessByStatus($this->template->content->item->ft_status)){
                    $this->error .= 'Запрещённая операция' . $this->NL();
                }else{
                    $id = intval($this->uri->segment('id'));

                    $this->makeCopy('footballers_store', 'ft_id', $id, 'ft_status');

                    $status = $this->db->update('footballers_store', $data, array('ft_id' => $id));

                    if(count($status)){
                        $this->info = 'Футболист отредактирован.';
                        url::redirect(url::site() . "footballers/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                        exit();
                    }
                }
            }
        }
    }

    public function photo() {

        $this->template->content = new View('footballers/photo');
        $this->template->title = 'Редактирование фотографий';
        $this->selected_page    = PAGE_FOOTBALLERS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

        $this->template->content->best = intval($this->uri->segment('best'));

        $srcPhoto = ($this->template->content->best) ? $this->template->content->item->ft_photo_best : $this->template->content->item->ft_photo;
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

            if(!$this->haveAccessByStatus($this->template->content->item->ft_status)){
                $this->error .= 'Запрещённая операция' . $this->NL();
            }else{
                //$zoom = round( $size[0] / $this->info['im_copy_wigth'], 4);
                $zoom = 1;

                if($this->template->content->best){
                    $copiedFile = STORE_DISK . '/' . STORE_BEST . '/' . $this->template->content->item->ft_id . '.jpg';
                }else{
                    $copiedFile = STORE_DISK . '/' . STORE_AVATARS . '/' . $this->template->content->item->ft_id . '.jpg';
                }

                $cmd_command = 'convert ' . escapeshellarg($srcPhoto) . '  -quality 75 -compress JPEG -coalesce ' .
                        '-crop "' . ceil($zoom * $coordinates['w']) . 'x' . ceil($zoom * $coordinates['h']) . '+' .
                        ceil($zoom * $coordinates['x']) . '+' . ceil($zoom * $coordinates['y']) . '" '.
                        " -geometry " . $this->template->content->templateW . "x" . $this->template->content->templateH . " +repage " .
                        escapeshellarg($copiedFile);
                $this->exec($cmd_command);

                if(!$this->template->content->best){

                    $table = "teams_store";
                    $where = "tm_id = " . $this->template->content->item->tm_id;
                    $teamInfo = $this->db->select('*')->from($table)->where($where)->get();

                    if($teamInfo->count()){

                        $teamInfo = $teamInfo[0];
                        $countryImg = 'C:/srv/footboll/supporter/supporter-engine/countries/' . $teamInfo->tm_country_code . '.png';
                        $cmd_command = 'composite -gravity SouthWest -dissolve 100 "' . $countryImg . '" "' . $copiedFile . '" "' . $copiedFile . '"';
                        $this->exec($cmd_command);

                    }
                }

                url::redirect(url::site() . "footballers/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                exit();
            }
        }
    }

    public function index() {

        $this->template->content = new View('footballers/index');

        $this->template->title = 'Созданные игроки';
        $this->selected_page    = PAGE_FOOTBALLERS;
        $this->selected_subpage = Footballers_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $offset = $this->uri->segment('page');

        $page_limit = 25;

        //$base_url = 'products:'.$this->id;
        $table = 'footballers_store';
        $where = '1=1 and footballers_store.back_up_id is null';
  
        $offset = $page_limit * ($offset - 1);

        if(!isset($offset) || $offset <= 0){
            $offset = 1;
        }
	
        $this->template->content->items = $this->db->select('*')->from($table)->join('teams_store', 'footballers_store.tm_id', 'teams_store.tm_id')->
                where($where)->offset($offset)->limit($page_limit)->orderby('ft_name', 'acs')->get();

        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'    => 'footballers/index',

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

        $this->template->content = new View('footballers/info');
        $this->template->title = 'Информация об игроке';
        $this->selected_page    = PAGE_FOOTBALLERS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

/*        if ($_POST || $this->uri->segment('updated')){
 
            switch ($this->template->content->item->ft_status){
                case ITEM_STATUS_NEW:
                case ITEM_STATUS_SENT:
                    $status = $this->db->update('footballers_store', array("ft_status" => ITEM_STATUS_SENT), array('ft_id' => $this->template->content->item->ft_id));
                    if(count($status)){
                        $this->info = 'Футболист проработан';
                        $this->template->content->item->ft_status = ITEM_STATUS_SENT;
                    }
                    break;
                case ITEM_STATUS_IN_GAME:
                case ITEM_STATUS_RECOMMIT:
                    $status = $this->db->update('footballers_store', array("ft_status" => ITEM_STATUS_RECOMMIT), array('ft_id' => $this->template->content->item->ft_id));
                    if(count($status)){
                        $this->info = 'Элемент, используемый в игре, отредактирован';
                        $this->template->content->item->ft_status = ITEM_STATUS_RECOMMIT;
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
        $table = "footballers_store";
        $where = "ft_id = " . $id;
        $this->template->content->item = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->item = $this->template->content->item[0];
    }

} 