<?php

/**
 * @author 
 * @copyright (c) 2014, Arthur Verdon
 * 
 * 
 */

/**
 * the class who manage the interaction with a mysql database
 * 
 */
class db {

    private $hostname;
    private $username;
    private $password;
    private $database;
    private $driver;
    private $pdo;
    private $build_request;
    private $result_request;

    /**
     * 1) load the conf
     * 2) connect to DB 
     * @param array $db_conf This array must contain this four param : hostname,
     * username, password and database
     */
    public function __construct($db_conf = array()) {
        $this->build_request = "";

        if (empty($db_conf)) {
            $db_conf = excalibur::load_db_conf();
        }

        $this->hostname = $db_conf['hostname'];
        $this->username = $db_conf['username'];
        $this->password = $db_conf['password'];
        $this->database = $db_conf['database'];
        $this->driver = $db_conf['driver'];

        try {
            $this->pdo = new PDO($this->driver . ':host=' . $this->hostname . ';dbname=' . $this->database, $this->username, $this->password);
        } catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * You can make a personalize without using the query builder with this
     * function
     * @param string $query
     * @return \db
     */
    public function query($query) {
        $this->build_request = $query;

        return $this;
    }

    /**
     * Create a select request
     * 
     * Example :
     * <code>
     * $db =  new db;
     * 
     * //SELECT * FROM t_category
     * $db->select()->from('t_category');
     * 
     * //SELECT `id_category` FROM t_category
     * $db->select(array('id_category'))->from('t_category');
     * 
     * //SELECT * FROM t_category WHERE id_category = '1'
     * $db->select()->from('t_category')->where(array('id_category','=','1'));
     * </code>
     * @param array $row contains the row you want to select but if you let it 
     * empty it's select all row
     * @return \db
     */
    public function select($row = array()) {
        $this->build_request = "SELECT ";
        if (empty($row)) {
            $this->build_request .= "*";
        } else {
            if (is_array($row))
                $this->build_request .= implode(',', $row);
            else
                $this->build_request .= $row;
        }
        return $this;
    }

    /**
     * create an update request
     *
     * Example :
     * <code>
     * $db =  new db;
     * 
     * //UPDATE `t_category` SET id_category='1' 
     * $db->update('t_category',array('id_category'=>'1'));
     * 
     * //UPDATE `t_category` SET id_category='1' WHERE `id_category`='1'
     * $db->update('t_category',array('id_category'=>'1'))->where(array('id_category','=','1'))
     * </code>
     * @param string $table
     * @param array $row 
     * @return \db
     */
    public function update($table = '', $row = array()) {
        $this->build_request = "UPDATE `" . $table . "` SET ";
        $update_param = array();

        if (!empty($row)) {
            foreach ($row as $name_row => $value) {
                $update_param[] = $name_row . '=' . $this->pdo->quote($value);
            }

            $this->build_request .= implode(',', $update_param);
        }
        return $this;
    }

    /**
     * create an insert request
     * 
     * Example :
     * <code>
     * $db =  new db;
     * 
     * //INSERT INTO `t_category` (`id_category`,`cat_name`) VALUES ('1','test')
     * $db->insert(array('id_category'=>'1','cat_name'=>'test'),'t_category');
     * </code>
     * @param array $row contains an array like that : 
     * array('id_test'=>'1','tes_content'=>'sdlfdls');
     * @param string $table contain the name of the table
     * @return \db
     */
    public function insert($row = array(), $table = '') {
        $this->build_request = 'INSERT INTO `' . $table . '` ';
        $insert_row = array();
        $insert_value = array();

        if (!empty($row)) {
            foreach ($row as $name_row => $value) {
                $insert_row[] = '`' . $name_row . '`';
                $insert_value[] = $this->pdo->quote($value);
            }
            $this->build_request .= ' (' . implode(',', $insert_row) . ')';
            $this->build_request .= ' VALUES (' . implode(',', $insert_value) . ')';
        }
        return $this;
    }

    /**
     * begin a delete query
     * 
     * Example :
     * <code>
     * $db =  new db;
     * 
     * //DELETE FROM `t_category` WHERE `id_category`='1'
     * $db->delete()->from('t_category')->where(array('id_category','=','1'));
     * </code> 
     * @return \db
     */
    public function delete() {
        $this->build_request = 'DELETE ';
        return $this;
    }

    /**
     * add the from param to the query builder
     * @param array $table this param MUST contains the name of table
     * @return \db
     */
    public function from($table) {
        $this->build_request .= " FROM ";
        if (isset($table) && !empty($table)) {
            if (is_array($table)) {
                $this->build_request .= implode(",", $table);
            } else {
                $this->build_request .= '`' . $table . '`';
            }
        } else {
            exit("from function must have at min one table name");
        }
        return $this;
    }

    /**
     * add a WHERE condition to the SQL request
     * @param array $condition the array must be like this example: array('id','=','1')
     * @return \db
     */
    public function where($condition) {
        $where = " WHERE ";
        $where .= '`' . $condition[0] . '`' . $condition[1] . $this->pdo->quote($condition[2]);
        $this->build_request .= $where;

        return $this;
    }

    /**
     * add a AND with a condition to the SQL request
     * @param array $condition the array must be like this example: array('id','=','1')
     * @return \db
     */
    public function and_where($condition) {
        $and_where = " AND ";
        $and_where .= '`' . $condition[0] . '`' . $condition[1] . $this->pdo->quote($condition[2]);
        $this->build_request .= $and_where;

        return $this;
    }

    /**
     * add a OR with a condition to the SQL request
     * @param array $condition the array must be like this example: array('id','=','1')
     * @return \db
     */
    public function or_where($condition) {
        $or_where = " OR ";
        $or_where .= '`' . $condition[0] . '`' . $condition[1] . $this->pdo->quote($condition[2]);
        $this->build_request .= $or_where;

        return $this;
    }

    /**
     * execute the sql request
     * @return \db
     */
    public function execute() {
        $this->result_request = $this->pdo->query($this->build_request);

        return $this;
    }

    /**
     * return the sql request in a string
     * @return string
     */
    public function get_sql_request_string() {
        return $this->build_request;
    }

    /**
     * fetch your result in an associative array 
     * 
     * Example :
     * <code>
     * array( 
     * 	'0'=> array( "id_category"=> "1" ,"cat_name"=> "Apple"),
     * 	'1'=> array("id_category"=> "2" ,"cat_name"=> "foo" ),
     * 	'2'=> array("id_category"=> "3" ,"cat_name"=> "bar")
     * );
     * </code>
     * @return array
     */
    public function fetch_assoc() {
        $result = array();
        while ($row = $this->result_request->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * fetch your result in a numeric array
     * 
     * Example :
     * <code>
     * array (
     * 	'0'=> array('0'=>"1",'1'=>"Apple" ), 
     * 	'1'=> array('0'=>"2",'1'=>"foo"),
     * 	'2'=> array('0'=>"3",'1'=>"bar" )
     * );
     * </code>
     * @return array
     */
    public function fetch_num() {
        $result = array();
        while ($row = $this->result_request->fetch(PDO::FETCH_NUM)) {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * fetch your result as object in an array
     * 
     * Example : 
     * <code>
     * $db = new db();
     * $tab_category = $db->select()->from('t_category')->execute()->fetch_obj();
     * echo $tab_category[0]->id_category; // display the id of this record
     * </code>
     * @param string $class_to_use this param define the name of the class to 
     * use for the convertion in object. By default the class used is stdClass
     * @return type
     */
    public function fetch_obj($class_to_use = 'stdClass') {
        $result = array();
        
        foreach ($this->result_request->fetchAll(PDO::FETCH_CLASS, $class_to_use) as $row) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * destruct method close the connection to the server
     */
    public function __destruct() {
        $this->pdo = null;
    }

}
