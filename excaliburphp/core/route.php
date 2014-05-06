<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * Class who manage route system of the framework
 */
class route {

    const _404_ = '_404_';
    const _ROOT_ = '_root_';
    
    /**
     * get the URL and return it in array without the path of
     * the folder. The first param in the array contains the
     * command
     * @param string $url use to not load the route write in the browser
     * @return array contains the clean route in array
     */
    private static function get_clean_route($url = '') {
        if(empty($url)){
            $requestURI = explode('/', strtok($_SERVER["REQUEST_URI"], '?'));            
            $app_conf = excalibur::load_app_conf();
            $app_conf = explode('/',$app_conf['base_url']);
            for($i = 0; $i < sizeof($requestURI);$i++){
                if($requestURI[$i] == $app_conf[$i])
                    unset ($requestURI[$i]);
            }
        }
        else {
            $requestURI = explode('/', strtok($url, '?'));
        }
        return array_values($requestURI);
    }

    /**
     * Obtain the command name of the route
     * @param string $url use to not load the route write in the browser
     * @return array
     */
    private static function get_command($url = '') {
        $command = '';
        $clean_route = self::get_clean_route($url);
        if (isset($clean_route[0]) && !empty($clean_route[0])) {
            $command = $clean_route[0];
        }
        
        return $command;
    }

    /**
     * obtain the param name of the route
     * @param string $url use to not load the route write in the browser
     * @return array
     */
    private static function get_param_route($url = '') {
        $param = self::get_clean_route($url);
        unset($param[0]);

        return $param;
    }

    /**
     * get if the route has a param
     * @param string $url use to not load the route write in the browser
     * @return boolean
     */
    private static function is_param_in_route($url = '') {
        $is_param_in_route = false;

        if (!empty(self::get_param_route($url)[1])) {
            $is_param_in_route = true;
        }
        return $is_param_in_route;
    }

    /**
     * test if a controller is given
     * @return boolean
     */
    private function is_controller_empty($url = '') {
        $command = self::get_command($url);
        return empty($commmand);
    }

    /**
     * test if the controller exist
     * @param string $name_of_constoller
     * @return boolean
     */
    private static function is_controller_exist($name_of_controller = '') {
        $is_controller_exist = false;
        
        if (file_exists(CONTROLLERPATH . $name_of_controller . '.php')) {
            $is_controller_exist = true;
            require_once CONTROLLERPATH . $name_of_controller . '.php';
        }
        
        return $is_controller_exist;
    }

    /**
     * check if the command is in the route.conf file
     * @param type $command_name
     * @return boolean
     */
    private function is_command_overwrite($command_name = '') {
        $is_overwrite = false;

        foreach (excalibur::load_routes_conf() as $row => $path) {
            if ($row == $command_name)
                $is_overwrite = true;
        }

        return $is_overwrite;
    }

    /**
     * Check if the route is overwrite and if yes the framewrok go
     * to this route
     * @param string $url use to not load the route write in the browser
     */
    private function set_overwrite_route($url = '') {
        if (self::is_command_overwrite(self::get_command($url))) {
            $routes_conf = excalibur::load_routes_conf();
            include $routes_conf[self::get_command($url)];
            exit();
        }//else
    }

    /**
     * Check if the route exist and if yes the framewrok go
     * to 404 route
     * @param string $url use to not load the route write in the browser
     */
    private function set_404_route($url = '') {
        $routes_conf = excalibur::load_routes_conf();
        if (!self::is_controller_exist(self::get_command($url))) {
            include $routes_conf[self::_404_];
            exit();
        }//else
    }

    /**
     * set the default root if no route define in the URL 
     * @param string $url use to not load the route write in the browser
     */
    private function set_root_route($url = '') {
        $routes_conf = excalibur::load_routes_conf();
        $app_conf = excalibur::load_app_conf();
        if (self::get_command($url) == self::get_command($app_conf['base_url'])) {
            $_root_ = explode('/', $routes_conf[self::_ROOT_]);
            $command = $_root_[0];
            $param = $_root_[1];
            if(!self::is_controller_exist($command)){
                include $routes_conf[self::_404_];
                exit();
            }
            self::make_route($command.'/'.$param);
            exit();
        }
    }

    /**
     * This method go to the route who is write in the URL
     * @param string $url use to not load the route write in the browser
     */
    private static function make_route($url = '') {
        $routes_conf = excalibur::load_routes_conf();
        
        $command = self::get_command($url);
        if(!isset($controller))
            $controller = new $command;
        
        if (self::is_param_in_route($url)) {
            $param = self::get_param_route($url);
            if (method_exists($controller, $param[1])) {
                $controller->$param[1]();
            } else {
                include $routes_conf[self::_404_];
            }
        } else {
            if (method_exists($controller,'index')){
                $controller->index();
            }
        }        
        exit();
    }
    
    

    /**
     * 1) Check if the url is the home route
     * 2) Check if the route is define in the conf file
     * 3) Check if the route exist
     * 4) make the route
     * exemple :
     * <code>
     * // this will redirect the route to the controller home with method index
     * route::set_route('home/index');
     * </code>    
     * @param string $url with this param you can define a manual route. If you
     * let this param empty the route will analyse the url
    */
    public static function set_route($url = ''){
        self::set_root_route($url);
        self::set_overwrite_route($url);
        self::set_404_route($url);
        self::make_route($url);
    }

}
