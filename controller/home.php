<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * Use for the information page and the home of the site
 *
 */
class home extends controller {

    public $template = 'template_app.php';

    public function index() {
        $this->information();
    }

    public function information() {
        $this->template->set_var('title', 'Page d\'information');
        $this->template->set_var('menu', view::get_content('vertical_menu.php'));
        $this->template->set_var('content', view::get_content('home/info_page.php'));
        $this->template->forge();
    }

}
