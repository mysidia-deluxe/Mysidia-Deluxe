<?php

class Online extends UserContainer{
  protected $members;
  protected $visitors;
  
  public function __construct($fetchmode = "all"){
	  // Constructor of Online object
	  	  
	  switch($fetchmode){
	     case "members":
		    $this->getonlinemembers();
			break;
		 case "visitors":
            $this->getonlinevisitors();
            break; 
         case "all":
            $this->getonlinemembers();
			$this->getonlinevisitors();
            break;
         default:
            throw new Exception("Undefined fetchmode specified");		 
	  }
	  // End of switch statement 	  
  }
  
  public function getonlinemembers(){
      $mysidia = Registry::get("mysidia");
	  if(empty($this->members)){
	     $data = $mysidia->db->select("online", array(), "username != 'Visitor'")->fetchAll();
         $this->members = count($data);
	  }
	  return $this->members;	 
  }
  
  public function getonlinevisitors(){
      $mysidia = Registry::get("mysidia");
	  if(empty($this->visitors)){
	     $data = $mysidia->db->select("online", array(), "username = 'Visitor'")->fetchAll();
         $this->visitors = count($data);
	  }
      return $this->visitors;	  
  }
  
  public function gettotal(){
      return ($this->members + $this->visitors);
  }
  
  public function update(){
     $mysidia = Registry::get("mysidia");
	 $session = $mysidia->session->getid();
	 $date = new DateTime;
     $currenttime = $date->getTimestamp();
     $expiretime = $date->modify("-5 minutes")->getTimestamp();	 
	 $username = (!$mysidia->user->isloggedin)?"Visitor":$mysidia->user->username;
     $ip = $_SERVER['REMOTE_ADDR'];
     $userexist = $mysidia->db->select("online", array("username"), "username = '{$username}' and ip = '{$ip}'")->fetchColumn();
	 if(!$userexist) $mysidia->db->insert("online", array("username" => $username, "ip" => $ip, "session" => $session, "time" => $currenttime)) or die('Cannot insert user data.');
	 else $mysidia->db->update("online", array("time" => $currenttime, "session" => $session, "username" => $username), "username = '{$username}' and ip = '{$ip}'");
     $mysidia->db->delete("online", "time < {$expiretime}");
  }

  public function display(){

  }
}
?>