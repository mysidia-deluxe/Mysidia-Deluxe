<?php

class VisitorCreator extends UserCreator{
  // The abstract factory class UserCreator
  protected $ip;
  protected $identitiy;
  protected $user;
   
  public function __construct($ip){
     $this->ip = $ip;
	 $this->identity = $this->getidentity($this->ip);
  }

  public function create(){
     switch($this->identity){
        case "Spider":
		   $user = $this->create_spider();
		   break;
        default:
		   $user = $this->create_guest();           		
     }
     return $user;	 
  }
  
  public function massproduce(){
     return FALSE;
  }
  
  private function create_spider(){
     return new Spider($this->ip);
  }
      
  private function create_guest(){
     return new Visitor($this->ip);
  }
  
  private function create_banned(){
     return new Spider($this->ip);
  }
}
?>