<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * view class make the usage of the view easier
 *
 */
class view {

    /**
     * return the content of a file. Use this function for just have the content
     * of the file set in param without display it
     * @param string $view_file
     * @param array $view_var
     * @return boolean
     */
    public static function get_content($view_file, $view_var = array()) {
        $view_file = VIEWPATH . $view_file;
        if (is_file($view_file)) {
            ob_start();
            extract($view_var, EXTR_SKIP);
            include $view_file;
            return ob_get_clean();
        }
        else
            return false;
    }

    /**
     * include the file. Use this function for include directly a view with different
     * var
     * @param string $view_file
     * @param array $view_var
     */
    public static function forge($view_file, $view_var = array()) {
        $view_file = VIEWPATH . $view_file;
        extract($view_var, EXTR_SKIP);
        include $view_file;
    }

}
