<?php

/**
 * This script load class and config
 * 
 */
require COREPATH . 'excalibur.php';
//Execute autoload
excalibur::init_autoload();

// Set the route
route::set_route();