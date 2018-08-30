<?php

use Resource\Native\Object;

abstract class Validator extends Object implements Validative{
  // The abstract Validator class offers basic functionalities 
  protected $action;
  protected $value;
  protected $data;
  protected $error = "";

  public function initialize($action = NULL, $value = NULL, $error = NULL){
      // The constructor of our abstract validator  
	  if ($action !== NULL) $this->setaction($action);
      if ($value !== NULL) $this->setvalue($value);
      if ($error !== NULL) $this->seterror($error);
  }
  
  public function setaction($action){
      $this->action = $action;
  }
   
  public function getaction(){
      return $this->action;
  }
  
  public function setvalue($value){
      $this->value = $value;
  }
   
  public function getvalue(){
      return $this->value;
  }
  
     
  public function seterror($error, $overwrite = FALSE){
      $br = "<br>";
      if (!is_string($error) or empty($error)) throw new Exception('The error message is invalid. It must be a non-empty string.');
      elseif($overwrite == TRUE) $this->error = $error;
	  else $this->error .= $error.$br;
  }
   
  public function triggererror(){
      if(empty($this->error)) return FALSE;
	  else return $this->error;
  }
  
  public function reseterror(){
      $this->error = "";
  }
  
  public function emptyvalidate($field){
	  if(empty($field)) return FALSE;
	  else return TRUE;
  }
  
  public function numericvalidate($field){
	  if(!is_numeric($field)) return FALSE;
	  else return TRUE;
  }
  
  public function datavalidate($table, $fields, $whereclause){
      $mysidia = Registry::get("mysidia");
	  $data = $mysidia->db->select($table, $fields, $whereclause)->fetchObject();
	  if(!is_object($data)) return FALSE;
	  else{
         $this->data = $data;        
         return TRUE;
      }
  }
  
  public function matchvalidate($var1, $var2, $approach = ""){
      switch($approach){
	     case "preg_match":
		 return preg_match($var1, $var2);
		 break;
	  default:
	     if($var1 == $var2) return TRUE;
		 else return FALSE;
	  }
      // End of the switch statement	  
  } 
  
  abstract public function validate();  
} 
?>