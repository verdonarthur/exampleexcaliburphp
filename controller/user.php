<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * Description of user
 *
 */
class user extends controller{
    public $template='template_app.php';
    
    public function before(){
        $session = session::get('username');
        if(empty($session)){
            route::set_route('connection/connect');
        }
    }
    
    public function index(){
        $this->show_profile();
    }
    
    public function show_profile(){
        $this->template->set_var('title','show profile');
        $this->template->set_var('menu',view::get_content('vertical_menu.php'));
        $user = model_users::find_by_login(session::get('username'));
        
        $this->template->set_var('content',view::get_content('user/show_profile.php',array('user'=>$user)));
        $this->template->forge();
    }
    
    public function modify_password(){
        $this->template->set_var('title','modify password');
        $this->template->set_var('menu',view::get_content('vertical_menu.php'));
        $result = '';
        if(!empty($_POST)){
            if(model_users::is_password_correct(session::get('username'), $_POST['oldpassword'])){
                $user = model_users::find_by_login(session::get('username'));
                $user->use_password = sha1($_POST['newpassword']);
                $user->save();
                $result = 2;
            }
            else{
                $result = 1;
            }
        }
        $this->template->set_var('content',view::get_content('user/modify_password.php',array('result'=>$result)));
        $this->template->forge();        
    }
}
