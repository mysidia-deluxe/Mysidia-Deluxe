<?php

class Visitor extends User{
  public $isloggedin;
  public $error;
  
  public function __construct($uid){
	  // Fetch the basic member properties for users
	  
      $this->uid = 0;
	  $this->ip = $_SERVER['REMOTE_ADDR'];
	  $this->usergroup = new UserGroup("visitors");;
	  
	  $time = new DateTime();
      $this->lastactivity = $time->getTimestamp();
      $this->isloggedin = UserCreator::logincheck();	  
  }
  
  public function __call($method, $param){
      // This magic method triggers when visitors attempt to visit pages inaccessible to guests
	  
	  $this->error = "The functionality is unavailable for guests, please log in or register.";
	  return FALSE;
  }
  
  public function __get($param){
      // This magic method triggers when visitors attempt to visit pages inaccessible to guests
	  
	  $param = 0;
	  return $param;
  }
  
  public function register(){
      // Will be added in future
	  $mysidia = Registry::get("mysidia");
	  $date = new DateTime;
	  $salt = codegen(15);
	  $password = passencr($mysidia->input->post("username"), $mysidia->input->post("pass1"), $salt);
	  // Insert the very first row of data for user registration
      $mysidia->db->insert("users", array("uid" => NULL, "username" => $mysidia->input->post("username"), "salt" => $salt, "password" => $password, "session" => NULL, "email" => $mysidia->input->post("email"), "ip" => $_SERVER['REMOTE_ADDR'], 
			                         "usergroup" => 3, "birthday" => $mysidia->input->post("birthday"), "membersince" => $date->format('Y-m-d'), "money" => $mysidia->settings->startmoney, "friends" => NULL));
	  $uid = $mysidia->db->select("users", array("uid"), "username = '{$mysidia->input->post("username")}'")->fetchColumn();
	  
	  // Now update the session
	  $myssession = md5($uid.$mysidia->session->getid());
	  $mysidia->db->update("users", array("session" => $myssession), "uid = '{$uid}'");	

      // Insert user data to the other tables
	  $mysidia->db->insert("users_contacts", array("uid" => $uid, "username" => $mysidia->input->post("username"), "website" => NULL, "facebook" => NULL, "twitter" => NULL, 
	                                           "aim" => NULL, "yahoo" => NULL, "msn" => NULL, "skype" => NULL));
	
	  $mysidia->db->insert("users_options", array("uid" => $uid, "username" => $mysidia->input->post("username"), "newmessagenotify" => 1, "pmstatus" => 0, 
	                                          "vmstatus" => 0, "tradestatus" => 0, "theme" => $mysidia->settings->theme));

      $mysidia->db->insert("users_profile", array("uid" => $uid, "username" => $mysidia->input->post("username"), "avatar" => $mysidia->input->post("avatar"), "bio" => $mysidia->input->post("bio"), "color" => $mysidia->input->post("color"), 
	                                          "about" => NULL, "favpet" => 0, "gender" => $mysidia->input->post("gender"), "nickname" => $mysidia->input->post("nickname")));											  
	
	  $mysidia->db->insert("users_status", array("uid" => $uid, "username" => $mysidia->input->post("username"), "canlevel" => 'yes', "canvm" => 'yes', "canfriend" => 'yes', 
	                                         "cantrade" => 'yes', "canbreed" => 'yes', "canpound" => 'yes', "canshop" => 'yes'));        
  }
  
  public function login($username){
      $mysidia = Registry::get("mysidia");
	  if($this->ip != $mysidia->session->clientip) throw new Exception('Your IP has changed since last session, please log in again.');
	  else{	     
	     $mysidia->cookies->setcookies($username);
	     $mysidia->db->update("users", array("session" => $mysidia->cookies->getcookies("myssession")), "username = '{$username}'");		 
		 include("inc/config_forums.php");
         if($mybbenabled == 1){
            include_once("functions/functions_forums.php");   
            mybblogin();
         }
         return TRUE;
	  }	 
  }
  
  public function logout(){
      throw new GuestNoaccessException($mysidia->lang->global_guest);
  }
  
  public function reset($username, $email){
      $mysidia = Registry::get("mysidia");
      $newpw = codegen(12);
      $newsalt = codegen(15,0);
      $newpass = passencr($username, $newpw, $newsalt);

      //Update the database with the new password...
      $mysidia->db->update("users", array("password" => $newpass, "salt" => $newsalt), "username='{$username}' and email='{$email}'");

      //Delete the entry from the password reset table
      $mysidia->db->delete("passwordresets", "code='{$mysidia->input->post("resetcode")}'");
      return $newpw;	  
  }

  public function getVotes($time = "today"){
	  $mysidia = Registry::get("mysidia");
      $date = new DateTime($time);
	  $ip = secure($_SERVER['REMOTE_ADDR']);
      $votes = $mysidia->db->select("vote_voters", array("void"), "ip = '{$ip}' and date = '{$date->format('Y-m-d')}'")->rowCount();
      return $votes;  
  }
}
?>