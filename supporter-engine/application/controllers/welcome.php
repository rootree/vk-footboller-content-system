<?php defined('SYSPATH') OR die('No direct access allowed.');

class Welcome_Controller extends Web_Controller {

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER,
            'edit' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'photo' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'add' => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
            'info' => ACCESS_ADMIN + ACCESS_MODER
        );

    }
 
    public function index() {
        
        $this->template->content = new View('welcome_content');
 
        $this->template->title = 'Статистика проекта';

        $this->selected_page = PAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };



        $ctx = stream_context_create(array(
            'http' => array(
                'method'=>"GET",
                'timeout' => 3
                )
            )
        );

        $this->template->content->contentGameServer = @file_get_contents(SERVER_GAME, 0, $ctx);
        $this->template->content->contentStaticServer = @file_get_contents(SERVER_STATIC, 0, $ctx);
        $this->template->content->contentStatisticServer = @file_get_contents(SERVER_STATISTIC, 0, $ctx);

        
        
    }
  
} // End Welcome Controller