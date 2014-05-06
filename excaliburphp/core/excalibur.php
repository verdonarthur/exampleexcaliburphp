<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * the core class of the framework. If this class not init all the framework
 * won't work
 */
class excalibur {
    /**
     * Load the class
     * @param string $class name of the class who gonna be load
     */
    private static function autoload_path($class){
        if(file_exists(COREPATH. $class . '.php'))
                require COREPATH. $class . '.php';
        else{
            self::load_subfolder_class('', $class);
        }
    }
    /**
     * Use to load class in subfolder with the convention "subfoldername_classname"
     * @param string $path_to_load
     * @param string $class_name
     * @return boolean
     */
    private static function load_subfolder_class($path_to_load,$class_name){
        $separate_char = '_';
        $file = str_replace($separate_char, DIRECTORY_SEPARATOR, $class_name) . '.php';
        
        if(!file_exists($path_to_load.$file)) {
            return false;
        }
        else {
            require_once $path_to_load.$file;
        }
    }
    /**
     * this function init the autoloading of class
     */
    public static function init_autoload() {
        spl_autoload_register(function ($class) {
            self::autoload_path($class);
        });
    }
    /**
     * Load the configuration of the app
     * @param array $app_conf
     */
    public static function load_app_conf() {
        $app_config = include(CONFIGPATH.'app.conf.php');
        return $app_config;
    }
    /**
     * Load the configuration of the routes
     * @param array $routes_conf
     */
    public static function load_routes_conf() {
        $routes_config = include(CONFIGPATH.'routes.conf.php');
        return $routes_config;
    }
    /**
     * Load the configuration of the db
     * @return array $db_config
     */
    public static function load_db_conf(){
        $db_config = include(CONFIGPATH.'db.conf.php');
        return $db_config;
    }
}
