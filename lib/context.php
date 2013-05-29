<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of context
 *
 * @author murdock
 */
class context {

  var $dbserver = "";
  var $dbusername = "";
  var $dbpassword = "";
  var $dbname = "";
  var $recordCount = 0;
  var $RES = "";
  var $ID = "";
  var $lastID = "";
  var $field = "";
  var $data = array();
  var $sql = "";
  var $tableName = "";
  var $idName = "";
  var $searchFields = array();
  var $onChange = "";

  /**
   * @author Mauricio Giraldo
   * @desc Object constructor
   * @version 1.0 03/05/2010
   * @param None
   * @return Boolean
   */
  function __construct() {
    return $this->connect();
  }

  /**
   * @author Mauricio Giraldo
   * @desc Connects to the database and returns a pointer to the connection
   * @version 2.0 05/27/2013
   * @param None
   * @return Resultset pointer
   */
  public function Connect() {
    $logger = new logFactory();
    logFactory::log($this, "Connecting to " . DBUSER . "@" . DBSERVER . "/" . DBNAME);
    $this->ID = mysql_connect(DBSERVER, DBUSER, DBPASSWORD) or $logger->log($this, "'Error Connecting:" . mysql_error());
    mysql_select_db(DBNAME) or $logger->log($this, "Error Selecting DB:" . mysql_error());
  }

  public function DynamicCall() {

    $this->Connect();

    $call = $_REQUEST["doCall"];

    //print $call;

    foreach ($_REQUEST as $key => $value) {
      $this->$key = $value;
    }

    if (method_exists($this, $call)) {
      call_user_func(array($this, $call));
    }
  }

  /**
   * @author Mauricio Giraldo
   * @desc Executes a query stores in $sql variable
   * @version 1.0 03/05/2010
   * @param None
   * @return Boolean
   */
  public function Query($sql = "") {
    $logger = new logFactory();
    if (!$sql)
      $sql = $this->sql;
    // Validate malicious code is not present:
    if (!strpos(strtolower($sql), "alter table") && !strpos(strtolower($sql), "drop table") && !strpos(strtolower($sql), "create table")) {
      logFactory::log($this, $sql);
      $this->RES = mysql_query($sql) or $logger->log($this, "SQL ERROR: " . $sql . ", " . mysql_error());
      return true;
    }
    else
      return false;
  }

  /**
   * @author Mauricio Giraldo
   * @desc Returns the last ID of the inserted value
   * @version 1.0 03/05/2010
   * @param None
   * @return Last ID
   */
  public function GetLastId() {
    $this->last_id = mysql_insert_id();
    return $this->last_id;
  }

  /**
   * @author Mauricio Giraldo
   * @desc Returns the number of records of the query
   * @version 1.0 03/05/2010
   * @param None
   * @return Last ID
   */
  public function Lines() {
    //$this->filas = mysql_num_rows($this->RES) or die(mysql_error());
    $this->recordCount = mysql_num_rows($this->RES) or print(mysql_error());
    return $this->recordCount;
  }

  /**
   * @author Mauricio Giraldo
   * @desc Returns the number of affected records by the query
   * @version 1.0 07/15/2010
   * @return count of affected rows
   */
  public function Affected() {
    return mysql_affected_rows($this->RES);
  }

  /**
   * @author Mauricio Giraldo
   * @desc Returns the number of records of the query
   * @version 1.0 05/27/2013
   * @param None
   * @return Boolean
   */
  public function Load() {
    $this->field = mysql_fetch_object($this->RES);
    $class_vars = get_class_vars(get_class($this));
    foreach ($class_vars as $name => $value) {
      $this->$name = $this->field->$name;
    }
    return true;
  }
  
  /**
   * @author Mauricio Giraldo
   * @desc Returns the number of records of the query
   * @version 1.0 05/27/2013
   * @param None
   * @return Boolean
   */
  public function GetParameters() {
    $class_vars = get_class_vars(get_class($this));
    foreach ($class_vars as $name => $value) {
      $this->data[$name] = $_REQUEST[$name];
    }
    return true;
  }
  
  /**
   * @author Mauricio Giraldo
   * @desc Insert one record in the database
   * @version 1.0 03/05/2010
   * @param None
   * @return Boolean
   */
  public function InsertOne() {
    $d = $this->getInsertValues();
    $this->sql = "INSERT INTO " . $this->tableName . " (" . $d[0] . ") VALUES (" . $d[1] . ")";
    return $this->query();
  }

  /**
   * @author Mauricio Giraldo
   * @desc Get one record in the database based on the ID passed
   * @version 1.0 05/20/2010
   * @param $mode: Selection mode: default=all, paged
   * @return Boolean
   */
  public function GetAll() {
    $this->sql = "SELECT * FROM " . $this->tableName;
    return $this->query();
  }

  /**
   * @author Mauricio Giraldo
   * @desc Get one record in the database based on the ID passed
   * @version 1.0 03/05/2010
   * @param $id of the record to retrieve
   * @return Boolean
   */
  public function GetOne($id) {
    $this->sql = "SELECT * FROM " . $this->tableName . " WHERE " . $this->idName . " = " . $id;
    return $this->query();
  }
  
  /**
   * @author Mauricio Giraldo
   * @desc Updates one record in the database
   * @version 1.0 03/05/2010
   * @param $id of the record to update
   * @return Boolean
   */
  public function UpdateOne($id) {
    $d = $this->getUpdateValues();
    $this->sql = "UPDATE " . $this->tableName . " SET " . $d[0] . " WHERE " . $this->idName . " = " . $id;
    return $this->query();
  }

  /**
   * @author Mauricio Giraldo
   * @desc Delete one record in the database
   * @version 1.0 03/05/2010
   * @param $id of the record to delete
   * @return Boolean
   */
  public function deleteOne($id) {
    $d = $this->getInsertValues();
    $this->sql = "DELETE FROM " . $this->tableName . " WHERE " . $this->idName . " = " . $id;
    return $this->query();
  }
  
  /**
   * @author Mauricio Giraldo
   * @desc This function get the values for the insert query
   * @version 1.0 03/05/2010
   * @param None
   * @return Array of fields
   */
  public function getInsertValues() {
    $keys = "";
    $values = "";
    while (list ($key, $val) = each($this->data)) {
      $keys .= $key . ",";
      $values .= $val . ",";
    }

    return array(substr($keys, 0, -1), substr($values, 0, -1));
  }

  /**
   * @author Mauricio Giraldo
   * @desc This function get the values for the update query
   * @version 1.0 03/05/2010
   * @param None
   * @return Array of fields
   */
  public function getUpdateValues() {
    $sets = "";
    while (list ($key, $val) = each($this->data)) {
      $sets .= $key . " = " . $val . ",";
    }
    return array(substr($sets, 0, -1));
  }

}

?>
