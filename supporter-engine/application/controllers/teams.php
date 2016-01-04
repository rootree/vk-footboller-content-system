<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Рассылка сообщений пользователям
 *
 * @package    Notify
 * @author     Ivan Chura
 */
class Teams_Controller extends Web_Controller {

    const SUBPAGE_MAIN    = 'main';
    const SUBPAGE_ADD = 'add';

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'photo' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'add' => ACCESS_ADMIN + ACCESS_MODER ,
            'info' => ACCESS_ADMIN + ACCESS_MODER
        );

    }

    public function add() {

        $this->template->content = new View('teams/add');

        $this->template->title = 'Добавление команды';
        $this->selected_page    = PAGE_TEAMS;
        $this->selected_subpage = Teams_Controller::SUBPAGE_ADD;

        if(!$this->haveAccess()){
            return;
        };

        $this->template->content->champ = $this->db->select('*')->from('cups_store')->
                where('1=1 AND back_up_id is null AND moder_rating > 0')->orderby('cp_name', 'asc')->get();

        if ($_POST){
 
            $data['tm_name'] = trim($_POST['footballer']['name']);
            $data['tm_photo'] = trim($_POST['footballer']['photo']);
            $data['cp_id'] = intval(@$_POST['footballer']['champ']);
            $data['moder_id'] = $this->moderId;

            $data['tm_status']  = ITEM_STATUS_NEW ;

            if(empty($data['tm_name'])){
                $this->error .= 'Укажите название команды' . $this->NL();
            }

            if(empty($data['cp_id'])){
                $this->error .= 'Укажите чемпионат' . $this->NL();
            }
            
            if(empty($data['tm_photo'])){
                $this->error .= 'Укажите адрес фотографии игрока для анкеты' . $this->NL();
            }elseif(!valid::URL($data['tm_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии для анкеты' . $this->NL();
            }

            if(is_null($this->error)){

                $status = $this->db->insert('teams_store', $data);

                if(count($status)){
                    $this->info = 'Команда добавлена.';
                    url::redirect(url::site() . "teams/info/id/" . $status->insert_id());
                    exit();
                }
            }
        }
    }

    public function edit() {

        $this->template->content = new View('teams/edit');
        $this->template->title = 'Редактирование конады';
        $this->selected_page    = PAGE_TEAMS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->template->content->champ = $this->db->select('*')->from('cups_store')->
                where('1=1 AND back_up_id is null AND moder_rating > 0')->orderby('cp_name', 'asc')->get();

        $this->getFootballerInfo();

        if ($_POST){

            $data['tm_name'] = trim($_POST['footballer']['name']); 
            $data['tm_photo'] = trim($_POST['footballer']['photo']);
            $data['cp_id'] = intval(@$_POST['footballer']['champ']);
            $data['moder_id'] = $this->moderId;

            $data['tm_status']  = ITEM_STATUS_NEW ;

            if(empty($data['tm_name'])){
                $this->error .= 'Укажите название команды' . $this->NL();
            }

            if(empty($data['cp_id'])){
                $this->error .= 'Укажите чемпионат' . $this->NL();
            }
 
            if(empty($data['tm_photo'])){
                $this->error .= 'Укажите адрес фотографии игрока для анкеты' . $this->NL();
            }elseif(!valid::URL($data['tm_photo'])){
                $this->error .= 'Укажите правильный адрес фотографии для анкеты' . $this->NL();
            }

            if(is_null($this->error)){

                if(!$this->haveAccessByStatus($this->template->content->item->tm_status)){
                    $this->error .= 'Запрещённая операция' . $this->NL();
                }else{
                    $id = intval($this->uri->segment('id'));

                    $this->makeCopy('teams_store', 'tm_id', $id, 'tm_status');

                    $status = $this->db->update('teams_store', $data, array('tm_id' => $id));

                    if(count($status)){
                        $this->info = 'Команда отредактирована.';
                        url::redirect(url::site() . "teams/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                        exit();
                    }
                }
            }
        }
    }

    public function photo() {

        $this->template->content = new View('teams/photo');
        $this->template->title = 'Редактирование команды';
        $this->selected_page    = PAGE_TEAMS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo();

        $this->template->content->best = intval($this->uri->segment('best'));

        $srcPhoto = ($this->template->content->best) ? $this->template->content->item->tm_photo_best : $this->template->content->item->tm_photo;
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
            if(!$this->haveAccessByStatus($this->template->content->item->tm_status)){
                $this->error .= 'Запрещённая операция' . $this->NL();
            }else{

                $zoom = 1;

                $copiedFile = STORE_DISK . '/' . STORE_TEAMS . '/' . $this->template->content->item->tm_id . '.jpg';

                $cmd_command = 'convert ' . escapeshellarg($srcPhoto) . '  -quality 75 -compress JPEG -coalesce ' .
                        '-crop "' . ceil($zoom * $coordinates['w']) . 'x' . ceil($zoom * $coordinates['h']) . '+' .
                        ceil($zoom * $coordinates['x']) . '+' . ceil($zoom * $coordinates['y']) . '" '.
                        " -geometry " . $this->template->content->templateW . "x" . $this->template->content->templateH . " +repage " .
                        escapeshellarg($copiedFile);
//echo $cmd_command; exit();
                $this->exec($cmd_command);

                url::redirect(url::site() . "teams/info/id/" . intval($this->uri->segment('id')) . '/updated/yes');
                exit();
            }
        }
    }

    public function index() {

        $this->template->content = new View('teams/index');

        $this->template->title = 'Созданные команды';
        $this->selected_page    = PAGE_TEAMS;
        $this->selected_subpage = Teams_Controller::SUBPAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        $offset = $this->uri->segment('page');

        $page_limit = 25;
 
        $table = 'teams_store';
        $where = '1=1 and teams_store.back_up_id is null';

        $offset = $page_limit * ($offset - 1);
        if(!isset($offset) || $offset <= 0){
            $offset = 1;
        }

        $SQL =
                
"SELECT `teams_store`.tm_name, `teams_store`.tm_id, `teams_store`.tm_status,  `teams_store`.tm_complete, 
`cups_store`.cp_id,`cups_store`.cp_level,`cups_store`.cp_name,
`coaches_store`.ch_name, `coaches_store`.ch_id, 
`teams_store`.`tm_id` as tm_id,

(SELECT COUNT(`footballers_store`.`ft_id`) FROM `footballers_store` WHERE `footballers_store`.`tm_id` = `teams_store`.`tm_id` AND  footballers_store.back_up_id IS NULL) AS footballers_count

FROM (`teams_store`)
JOIN `cups_store` ON (`teams_store`.`cp_id` = `cups_store`.`cp_id` AND  cups_store.back_up_id IS NULL)
LEFT JOIN `coaches_store` ON (`coaches_store`.`tm_id` = `teams_store`.`tm_id` AND  coaches_store.back_up_id IS NULL)
WHERE 1=1 AND teams_store.back_up_id IS NULL
ORDER BY `cups_store`.`cp_name` ASC
LIMIT $offset, $page_limit";

        $this->template->content->items = $this->db->query($SQL);
   
        $count_records = $this->db->from($table)->
                where($where)->count_records();

        $pagination = new Pagination(array(
            // Base_url will default to the current URI
            'base_url'    => 'teams/index',

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

        $this->template->content = new View('teams/info');
        $this->template->title = 'Информация о команде';
        $this->selected_page    = PAGE_TEAMS;
        $this->selected_subpage = null;

        if(!$this->haveAccess()){
            return;
        };

        $this->getFootballerInfo(); 
    }

    private function getFootballerInfo($freshId = 0){
        /* if($freshId){
            $id = intval($this->uri->segment('id'));
        }else{
            $id = $freshId;
        }*/
        $id = intval($this->uri->segment('id'));
        $table = "teams_store";
        $where = "tm_id = " . $id;
        $this->template->content->item = $this->db->select('*')->from($table)->
                join('cups_store', 'cups_store.cp_id', 'teams_store.cp_id')->
                where($where)->get();
        
        $this->template->content->item = $this->template->content->item[0];
        
        $table = "coaches_store";
        $where = "tm_id = " . $id;
        $this->template->content->coaches = $this->db->select('*')->from($table)->
                where($where)->get();
        $this->template->content->coaches = $this->template->content->coaches[0];
        
        $table = "footballers_store";
        $where = "tm_id = " . $id . "  and back_up_id is null";
        $this->template->content->footballers = $this->db->select('*')->from($table)
                ->where($where)->get();
        
    }

} 