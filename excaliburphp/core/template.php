<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * this class use for the template management and make is utilisation
 * easier
 */
class template {

    private $template_file;
    private $template_var;

    /**
     * 
     * @param strig $template_path
     */
    public function __construct($template_path) {
        $this->template_file = $template_path;
        $this->template_var = array();
    }

    /**
     * forge the view with the template. All key set in the array will be import 
     * in the view as var php
     */
    public function forge() {
        extract($this->template_var, EXTR_SKIP);
        require VIEWPATH . $this->template_file;
    }
    
    /**
     * use this function for set a var in the actual template
     * @param string $name
     * @param string/int/object/array $value
     */
    public function set_var($name,$value){
        $this->template_var[$name] = $value;
    }

}
