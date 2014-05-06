<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * Description of admin
 *
 */
class admin extends controller{
    public $template='template_app.php';
    
    public function before(){
        $session = session::get('username');
        if(empty($session) OR session::get('userright') != 1){
            route::set_route('connection/connect');
        }
    }
    
    public function index(){
        $this->show_users();
    }
    
    public function show_users(){
        $this->template->set_var('title','show users');
        $this->template->set_var('menu',view::get_content('vertical_menu.php'));
        $users = model_users::find_all();        
        $this->template->set_var('content',view::get_content('admin/show_users.php',array('users'=>$users)));
        $this->template->forge();
    }
    
    public function modify_user(){
        $this->template->set_var('title','modify user');
        $this->template->set_var('menu',view::get_content('vertical_menu.php'));
        $user = model_users::find_by_pk($_GET['id_user']);        
        $this->template->set_var('content',view::get_content('admin/modify_user.php',array('user'=>$user)));
        $this->template->forge();
    }
    
    public function add_user(){
        $this->template->set_var('title','modify user');
        $this->template->set_var('menu',view::get_content('vertical_menu.php'));
        $user = new model_users();  
        $user->id_user = '';
        $user->use_name = '';
        $user->use_surname = '';
        $user->use_login = '';
        $user->use_password = '';
        $user->use_address = '';
        $user->use_locality = '';
        $user->use_NPA = '';
        $user->use_mail = '';
        $user->idx_right = '';
        $this->template->set_var('content',view::get_content('admin/modify_user.php',array('user'=>$user)));
        $this->template->forge();
    }
    
    public function delete_user(){
        if(isset($_GET['id_user']) && !empty($_GET['id_user'])){
            $user = model_users::find_by_pk($_GET['id_user']);
            $user->delete();
            route::set_route('admin/show_users');
        }
    }
    
    public function save_user(){
        if(!empty($_POST)){
            $user =  new model_users();
            $user->id_user = $_POST['id_user'];
            $user->use_name = $_POST['use_name'];
            $user->use_surname = $_POST['use_surname'];
            $user->use_login = $_POST['use_login'];
            $user->use_password = sha1($_POST['use_password']);
            $user->use_address = $_POST['use_address'];
            $user->use_locality = $_POST['use_locality'];
            $user->use_NPA = $_POST['use_NPA'];
            $user->use_mail = $_POST['use_mail'];
            $user->idx_right = $_POST['idx_right'];
            
            $user->save();
            
            route::set_route('admin/show_users');
        }
    }
}
