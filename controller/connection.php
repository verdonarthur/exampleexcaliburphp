<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * Description of connection
 *
 */
class connection extends controller{
    public $template = 'template_app.php';
    
    public function index(){
        $this->connect();
    }
    public function connect(){  
        $this->template->set_var('title','Page de connection');
        $this->template->set_var('menu',view::get_content('vertical_menu.php'));
        if(empty($_POST)){
            $this->template->set_var('content',view::get_content('connection/connect_page.php'));
        }
        else{
            if(model_connection::do_connection($_POST['username'], $_POST['password'])){
                route::set_route('user/index');
            }
            else{
                $this->template->set_var('content',view::get_content('connection/connect_error.php'));
            }
        }
        $this->template->forge();
    }
    public function disconnect(){
        session::destroy();
        route::set_route('home/index');
    }
}
