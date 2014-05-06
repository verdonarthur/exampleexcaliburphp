<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * 
 *
 */
class model_users extends orm{
    protected  static $table_name = 't_users';
    protected static $primary_key = 'id_user';
    protected static $properties = array(
        'id_user'=>array('type'=>'number','hide'=>1,'formproperties'=>array('size'=>11)),
        'use_name'=>array('type'=>'text','size'=>45),
        'use_surname'=>array('type'=>'text','size'=>45),
        'use_login'=>array('type'=>'text','size'=>45),
        'use_password'=>array('type'=>'password','size'=>64),
        'use_address'=>array('type'=>'text','size'=>45),
        'use_locality'=>array('type'=>'text','size'=>45),
        'use_NPA'=>array('type'=>'number','size'=>4),
        'use_mail'=>array('type'=>'mail','size'=>45),
        'idx_right'=>array('type'=>'text','size'=>45),
    );    
    /**
     * 
     * @param string $user_login
     * @return object
     */
    public static function find_by_login($user_login){
        $db = new db();
        $query = $db->select()
                ->from(self::$table_name)
                ->where(array('use_login','=',$user_login))
                ->execute()
                ->fetch_obj('model_users');
        return $query[0];
    }
    
    /**
     * check if the user exist
     * @param string $user_login
     * @return boolean
     */
    public static function is_user_login_exist($user_login)
    {
        $db = new db();
        $query = $db->select()
                ->from(self::$table_name)
                ->where(array('use_login','=',$user_login))
                ->execute()
                ->fetch_assoc();
        
        if(!empty($query)){
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * check if the password is correct
     * @param string $login_of_user
     * @param string $password_user
     * @return boolean
     */
    public static function is_password_correct($login_of_user,$password_user)
    {	
        $db = new db();
        $query =  $db->select()
                ->from(self::$table_name)
                ->where(array('use_login','=',$login_of_user))
                ->and_where(array('use_password','=',  sha1($password_user)))
                ->execute()
                ->fetch_assoc();
        if(!empty($query)){
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * return the id of the right
     * @param int $id_user
     * @return int
     */
    public static function get_right($id_user){
        $user = self::find_by_pk($id_user);
        
        return $user->idx_right;
    }
}
