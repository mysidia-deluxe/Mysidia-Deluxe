<?php

class Session extends Core{
  private $ssid;
  private $started = FALSE;
  private $initime;
  private $useragent;
  public $clientip;

  public function __construct(){
     // Start our session
     
     if(!isset($_SESSION)) session_start();
	 $this->started = TRUE;
	 
	 // Initiate our session properties
	 $this->ssid = session_id();
	 $this->initime = time();
	 $this->useragent = $_SERVER['HTTP_USER_AGENT'];
	 $this->clientip = $_SERVER['REMOTE_ADDR'];	 
  }
  
  public function getid(){
     if(empty($this->ssid)) $this->error("Session already expired...");	
	 else return $this->ssid; 
  }
  
  private function exist($name){
     if(!empty($_SESSION[$name])) return TRUE;
	 else return FALSE;
  }
  
  public function fetch($name){
     if($this->exist($name)) return $_SESSION[$name];
     else return FALSE;
  }
  
  public function assign($name, $value, $override = TRUE, $encrypt = FALSE){
     $value = ($encrypt == TRUE)?hash('sha512', $value):$value;
	 if(!empty($_SESSION[$name]) and $override == FALSE) $this->error("Cannot override session var {$name}.");	
	 else $_SESSION[$name] = $value;
  }
  
  public function terminate($name){
     if(!isset($_SESSION[$name])) return FALSE;	 
	 else unset($_SESSION[$name]);
  }
  
  public function regen($name){
     $this->ssid = session_regenerate_id();
	 $this->initime = time();
  }
  
  public function validate($name){
     if($this->useragent != $_SERVER['HTTP_USER_AGENT'] or $this->clientip != $_SERVER['REMOTE_ADDR']){ 
	    $this->destroy();
	    $this->error("User IP has changed...");
     }
	 elseif(!isset($_SESSION[$name])){
        $this->error("Session already expired...");
     } 
     else return TRUE;	 
  }
  
  public function destroy(){
     $_SESSION = array();
     session_destroy();
  }

  private function error($message){
     throw new Exception($message);	 
  }  
  
}
?>