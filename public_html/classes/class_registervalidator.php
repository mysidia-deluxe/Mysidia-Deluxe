<?php

class RegisterValidator extends UserValidator{
  // The register validator for user and usergroup system
    
  public function __construct(User $user, $value = array(), $action = ""){	  
	  parent::__construct($user, $value, $action);
  }
  
  public function validate($action = "", $data = ""){
      // The core method validate, it acts like a controller and sends requests to different private methods based on the action
	
	  $validarray = array("username", "password", "email", "birthday", "ip", "tos", "answer");
	  
	  // For RegisterValidator, the validator methods will be executed all at once
	  foreach($this->value as $key => $var){
	     $method = "{$key}validate";
		 if(in_array($key, $validarray)) $this->$method($var);
	     else throw new Exception('Validation action invalid...');

         if(!empty($this->error)) return FALSE;
	  }
  }
    
  protected function usernamevalidate($username = ""){
      // The username validator, note its a bit complicate here due to the different mechanism of username check for register and other validators
      $lang = Registry::get("lang");
	  if(!$this->emptyvalidate($username)){
         $this->seterror("The field Username is Empty.");
         return FALSE;
      }
	  $forbidden_names = array("SYSTEM", "ADMIN", "STAFF", "OWNER", "MODERATOR", "ERROR"); 

		if(in_array(strtoupper($username), $forbidden_names)){ 
			$this->seterror("Cannot use '$username' as username."); 
			return FALSE; 
		}
	  $username = (empty($username))?$this->value['username']:$username;	  
	  $userexist = $this->datavalidate("users", array("username"), "username = '{$username}'");
	  if($userexist == TRUE){
         $this->seterror($lang->user);
		 return FALSE;
      }
      else return TRUE;
  }
  
  protected function passwordvalidate($password = ""){ 
      $mysidia = Registry::get("mysidia");  
      if(!$this->emptyvalidate($this->value['password'])){
         $this->seterror("The field Password is empty.");
         return FALSE;   
      }
	  elseif(!$this->emptyvalidate($mysidia->input->post("pass2"))){
         $this->seterror("The field Confirmed Password is Empty.");
      }
      elseif(!$this->matchvalidate($this->value['password'], $mysidia->input->post("pass2"))){
		 $this->seterror($mysidia->lang->match);
	     return FALSE;
	  }
	  else return TRUE;
  }

  protected function emailvalidate($email = ""){
      $lang = Registry::get("lang");
      $email = (empty($email))?$this->value['email']:$email;	
      $this->emptyvalidate($email);
      $regex = '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';
      if(!$this->matchvalidate($regex, $email, "preg_match")){
	     $this->seterror($lang->email);
		 return FALSE;
	  }
      else return TRUE;
  }
     
  protected function birthdayvalidate($birthday = ""){
      $lang = Registry::get("lang");
      if(empty($this->value['birthday'])){
	     $this->seterror($lang->birthday, TRUE);
		 return FALSE;
	  }
	  else return TRUE;
  }

  protected function answervalidate($answer = ""){
      $mysidia = Registry::get("mysidia");
      if(!$this->matchvalidate($this->value['answer'], $mysidia->settings->securityanswer)){
	     $this->seterror($mysidia->lang->question);
		 return FALSE;
	  }
	  else return TRUE;
  }
  
  protected function tosvalidate($tos = ""){
      $lang = Registry::get("lang");
      $tos = (empty($tos))?$this->value['tos']:$tos;
      if($tos != "yes"){
	     $this->seterror($lang->tos);
		 return FALSE;	     
	  }
	  else return TRUE;
  }
 
}
?>