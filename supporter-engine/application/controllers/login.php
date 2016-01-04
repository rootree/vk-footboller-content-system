<?php defined('SYSPATH') OR die('No direct access allowed.');

class Login_Controller extends Web_Controller {

    public function __construct() {
        parent::__construct();
        $this->accessRules = array(
            'index' => ACCESS_ADMIN + ACCESS_MODER  + ACCESS_VIEWER + ACCESS_GUEST
        );

    }

    public function index() {

        $this->selected_page = PAGE_MAIN;

        if(!$this->haveAccess()){
            return;
        };

        if($_POST){
 
            $data['user_mail'] = trim($_POST['singin']['mail']);
            $data['user_word'] = md5(trim($_POST['singin']['word']) . WORD_SOLT);


            $SQLResult = $this->db->select('*')->from('moders')->
                    where($data)->get();

            if($SQLResult->count()){
                $moder = $SQLResult->current();
 
                $this->session->set("access", $moder->user_right);
                $this->session->set("moderId", $moder->user_id); 
  
                url::redirect("welcome/index");

                return;
                
            }else{

                $this->error .= "Указаны ошибочные данные" . $this->NL(); 
            }
 
        } 

        $this->template->content = new View('login');

        $this->template->title = 'Авторизация';

    }

    public function logout() {
        
        $this->session->set("access", ACCESS_GUEST);

        url::redirect("login/index");

    }

} // End Welcome Controller