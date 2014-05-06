<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * this class can help to create html tag
 *
 */
class html {

    /**
     * Create an a html tag. If you put a link like "controller/methode", this 
     * function will create an absolute link to the controller.
     * ex : 
     * <code>
     * // <a href='http://localhost/home/index'>Go to index</a>
     * html::a('home/index','Go to index');
     * </code>
     * @param string $href the link of href
     * @param string $link_name name of link
     * @param string $class class css to set for the a tag
     * @return string
     */
    public static function a($href, $link_name = null, $class = null) {
        $app_conf = excalibur::load_app_conf();
        $base_url = $app_conf['base_url'] == null ? '/' : $app_conf['base_url'];

        if (!preg_match('#^(\w+://|javascript:|\#)# i', $href)) {
            $href = 'http://' . $_SERVER['SERVER_NAME'] . $base_url . $href;
        }

        if (!empty($link_name) && !empty($class)) {
            $href = '<a href="' . $href . '" class="' . $class . '">' . $link_name . '</a>';
        } else if (!empty($link_name)) {
            $href = '<a href="' . $href . '">' . $link_name . '</a>';
        } else {
            $href = '<a href="' . $href . '">' . $href . '</a>';
        }

        return $href;
    }

    /**
     * this function help you for create an ul list in html. Just put an array
     * in param and BOUM, an ul list appear
     * @param array $array_of_ul
     * @param string $class you can set a css class for the list
     * @return string
     */
    public static function ul($array_of_ul, $class_ul, $class_li = '') {
        return self::create_list('ul', $array_of_ul, $class_ul, $class_li);
    }

    /**
     * this function help you for create an ul list in html. Just put an array
     * in param and BOUM, an ol list appear
     * @param type $array_of_ol
     * @param string $class you can set a css class for the list
     * @return type
     */
    public static function ol($array_of_ol, $class_ol = '', $class_li = '') {
        return self::create_list('ol', $array_of_ol, $class_ol, $class_li);
    }

    /**
     * 
     * @param type $type_list
     * @param type $array_list
     * @param string $class
     * @return string
     */
    private static function create_list($type_list, $array_list, $class_list = '', $class_li = '') {
        $list = '<' . $type_list . ' class=' . $class_list . '>';
        foreach ($array_list as $row => $elem) {
            if (!is_array($elem)) {
                $list.="<li class='$class_li'>$elem</li>";
            } else {
                $list.="<li class='$class_li'>" . self::create_list($type_list, $elem, $class_list, $class_li) . "</li>";
            }
        }
        $list .= '</' . $type_list . '>';

        return $list;
    }

    /**
     * this function help you to create img tag.
     * if $filename just contain a name, the app will search the image in the folder
     * img
     * @param string $filename
     * @param type $alt
     * @param type $class
     */
    public static function img($filename, $alt = '', $class = '') {
        if (!preg_match('#^(\w+://|javascript:|\#)# i', $filename) || !strstr($filename, '/')) {
            $app_conf = excalibur::load_app_conf();
            $base_url = $app_conf['base_url'] == null ? '/' : $app_conf['base_url'];
            $filename = 'http://' . $_SERVER['SERVER_NAME'] . $base_url . 'img/' . $filename;
        }

        echo '<img src="' . $filename . '" alt="' . $alt . '" class="' . $class . '">';
    }
    /**
     * Create a form.
     * @param string $action
     * @param array $option
     * @return string
     */
    public static function begin_form($action,$option = array()) {
        $app_conf = excalibur::load_app_conf();
        $base_url = $app_conf['base_url'] == null ? '/' : $app_conf['base_url'];
        if (!preg_match('#^(\w+://|javascript:|\#)# i', $action)) {
            $action = 'http://' . $_SERVER['SERVER_NAME'] . $base_url . $action;
        }
        
        $option_to_add = "";
        
        foreach($option as $option_name=>$value){
            $option_to_add .= $option_name.'="'.$value.'"';
        }
        
        $form = "<form action='$action' $option_to_add>";
    
        return $form;
    }
    /**
     * Create an input form
     * @param string $name
     * @param array $option
     * @return string
     */
    public static function input($name,$option = array()) {        
        return "<input name='$name' ".self::add_option($option).">";
    }
    
    /**
     * End a form begin with methode "begin_form"
     * @return string
     */
    public static function end_form(){
        return '</form>';
    }
    /**
     * include a js file contained in the js folder
     * @param type $filename
     */
    public static function include_js_file($filename) {
        include ROOTPATH . 'js/' . $filename;
    }

    /**
     * include a css file contained in the css folder
     * @param type $filename
     */
    public static function include_css_file($filename) {
        $app_conf = excalibur::load_app_conf();
        $base_url = $app_conf['base_url'] == null ? '/' : $app_conf['base_url'];
        $href = 'http://' . $_SERVER['SERVER_NAME'] . $base_url . 'css/' . $filename;
        echo '<link rel="stylesheet" type="text/css" href="' . $href . '">';
    }
    /**
     * return a div
     * @param type $properties
     * @return string
     */
    public static function begin_div($properties = array()){        
        return '<div '.self::add_option($properties).'>';
    }
    /**
     * return the end of a div
     * @return string
     */
    public static function end_div(){
        return '</div>';
    }
    /**
     * add a label tag
     * @param type $value
     * @param type $properties
     * @return type
     */
    public static function label($value,$properties = array()){
        return self::create_tag('label', $value, $properties);
    }
    /**
     * add a button tag
     * @param string $value
     * @param array $properties
     * @return string
     */
    public static function button($value,$properties = array()){
        return self::create_tag('button', $value, $properties);
    }
    /**
     * create table tag
     * @param type $properties
     * @return type
     */
    public static function begin_table($properties = array()){
        return '<table '.self::add_option($properties).' >';
    }
    /**
     * create the end table tag
     * @return string
     */
    public static function end_table(){
        return "</table>";
    }
    /**
     * create tr tag
     * @param string $value
     * @param array $properties
     * @return string
     */
    public static function tr($value,$properties = array()){
        return self::create_tag('tr', $value, $properties);
    }
    /**
     * create th tag
     * @param string $value
     * @param array $properties
     * @return string
     */
    public static function th($value,$properties = array()){
        return self::create_tag('th', $value, $properties);
    }
    /**
     * create td tag
     * @param string $value
     * @param array $properties
     * @return string
     */
    public static function td($value,$properties = array()){
        return self::create_tag('td', $value, $properties);
    }
    /**
     * create td tag
     * @param string $value
     * @param array $properties
     * @return string
     */
    public static function span($value,$properties = array()){
        return self::create_tag('span', $value, $properties);
    }
    /**
     * generic function for get the options in a array
     * @param string $options
     * @return string
     */
    private static function add_option($options){
        $options_to_add = '';
        foreach($options as $option_name=>$value){
            $options_to_add .= $option_name.'="'.$value.'" ';
        }
        return $options_to_add;
    }
    /**
     * generic function for creating html tag
     * @param type $tah
     * @param type $value
     * @param type $properties
     * @return type
     */
    private static function create_tag($tag,$value,$properties){
        return '<'.$tag.' '.self::add_option($properties).' >'.$value.'</'.$tag.'>';
    }
    
    
}
