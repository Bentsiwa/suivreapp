<?php
/**
*@author 
*@method boolean connect()
*@method string query(string $strQuery)
*@method string fetch()
*/

/**
*databasehelper  class
*/
class databasehelper{
  /**
  *@global string $db Contains instance of mysqli
  */
  var $db=null;
  
  /**
  *@global string $result sql query result
  */
  var $result=null;

  function databasehelper() {

   }
   /**
   *Connect to the database
   *@return returns boolean in it connects to database
   *@uses setting:: gets the connection details
   */
  function connect(){
   

  
   $this->db=new mysqli("localhost","id810289_efuabainson","efua.bainson","id810289_finalproject");
    //$this->db=new mysqli("localhost","root","","finalproject");
    if($this->db->connect_errno){
        return false;
    }
    return true;
  }
    /**
    *Query the database
    *@param string $strQuery sql string to execute
    */
  function query($strQuery){
    if(!$this->connect()){
        return false;
    }
    if($this->db==null){
        return false;
    }
   $this->result=$this->db->query($strQuery);
   if($this->result==false){
      return false;
   }
   return true;
 }
    /**
    *Fetch from the current data set and return
    *@param string $strQuery sql string to execute
    *@return array one record
    */
  function fetch(){

   if($this->result==null){
    return false;
   }

  if($this->result==false){
        return false;
  }

  return $this->result->fetch_assoc();
  }
}


?>