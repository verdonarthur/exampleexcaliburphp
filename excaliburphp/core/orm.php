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
abstract class orm {

    protected static $table_name;
    protected static $primary_key;
    protected static $properties;

    public function __construct() {
        
    }
    /**
     * return all record of the table
     * @return tab of object
     */
    public static function find_all() {
        $db = new db();
        $query = $db->select()->from(static::$table_name);

        return $query->execute()->fetch_obj(get_called_class());
    }
    /**
     * search a record and return it by his ID
     * @param int $id
     * @return object
     */
    public static function find_by_pk($id) {
        $db = new db();
        $query = $db->select()->from(static::$table_name)->where(array(static::$primary_key, '=', $id));
        $result = $query->execute()->fetch_obj(get_called_class());
        $result = empty($result) ? null : $result[0];        
        return $result;
    }
    /**
     * delete the current object in the DB
     * @return type
     */
    public function delete() {
        $db = new db();
        $primary = static::$primary_key;
        $query = $db->delete()->from(static::$table_name)->where(array(static::$primary_key, '=', $this->$primary));
        $query->execute();
    }    
    /**
     * override this function for execute treatment before a save
     */
    public function before_save(){
        
    }    
    /**
     * save the actual object in the the DB. If he doesn't exist a new record will
     * be create
     */
    public function save() {
        $db = new db();
        $array_data = array();
        $primary = static::$primary_key;
        $object = $this->find_by_pk($this->$primary);
        
        if (empty($object)) {
            foreach (static::$properties as $row => $properties) {
                $value = !isset($this->$row) ? '' : $this->$row;
                $array_data[$row] = $value;
            }
            $this->before_save();
            $db->insert($array_data, static::$table_name)->execute();
        } else {
            foreach (static::$properties as $row => $properties) {
                $value = !isset($this->$row) ? $object->$row : $this->$row;
                $array_data[$row] = $value;
            }
            $this->before_save();
            $db->update(static::$table_name, $array_data)->where(array(static::$primary_key,'=',$this->$primary))->execute();
        }
    }
    /**
     * this function allow to create a bootstrap form trough an orm model
    * @param string $action
     * @param array $option
     * @return string
     */
    public function create_bootrstrap_form($action,$option = array()){
        $form = html::begin_form($action,$option);
        
        foreach(static::$properties as $row=>$value){
            $form .= html::begin_div(array('class'=>'form-group'));
            $form .= html::label($row,array());
            if(isset($value['formproperties'])){
                $value['formproperties']['class'] = isset($value['formproperties']['class']) ? $value['formproperties']['class']: 'form-control';
                $formproperties = $value['formproperties'];
                $formproperties [] = $value['type'];
                $form .= html::input($row,  $formproperties);
            }
            else{
                $formproperties = array('class'=>'form-control');
                $formproperties [] = $value['type'];
                $form .= html::input($row,$formproperties);
            }
            $form .= html::end_div();
        }
            
        $form .= html::input('submit', array('type'=>'submit','class'=>'btn btn-default'));
        $form .= html::end_form();
        return $form;
    }
}
