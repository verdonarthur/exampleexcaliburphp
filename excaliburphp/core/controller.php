<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * Class who all controller MUST be extends
 * You can use a template if you set a public properties name $template with the
 * name of you're template contained in the view folder
 */
abstract class controller {

    public $template;/** using for the usage of template in a controller */

    /**
     * construct of the controller
     * 1) instance template class if this one is set
     */
    public function __construct() {
        $this->before();
        
        if (!empty($this->template))
            $this->template = new template($this->template);
    }
    
    public function before(){
        
    }

    /**
     * Default method who is called when the URL has not param. that's the equivalent 
     * of the index.html/index.php page
     */
    public function index() {
        
    }

}
