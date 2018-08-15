<?php

use Resource\Native\String as String;

class ForgotpassController extends AppController{

    public function __construct(){
        parent::__construct("guest");
    }
	
	public function index(){
		$mysidia = Registry::get("mysidia");		
		if($mysidia->input->post("submit")){
		    $user = $mysidia->db->select("users", array("username", "email", "ip"), "username = '{$mysidia->input->post("username")}' and email = '{$mysidia->input->post("email")}'")->fetchObject();
	        if(!is_object($user)) throw new PasswordException("match");			 
	        else{
	            $rand = codegen(10);
		        $date = new DateTime;
	            $mysidia->db->insert("passwordresets", array("id" => NULL, "username" => $mysidia->input->post("username"), "email" => $mysidia->input->post("email"), "code" => $rand, "ip" => $_SERVER['REMOTE_ADDR'], "date" => $date->format('Y-m-d')));

                $headers = "From: {$mysidia->settings->systememail}";	
                $message = "Hello there {$mysidia->input->post("username")}:\n\nOur records indicate that you requested a password reset for your account.  Below is your reset code:\n
                              Reset Code: {$rand}\n\nTo have your password changed please visit the following URL:\n
                              {$mysidia->path->getAbsolute()}forgotpass/reset 
                              \n\nIf you did NOT request a password reset then please ignore this email to keep your current password.\n\n
                              Thanks,\nThe {$sitename} team.";
		        mail($mysidia->input->post("email"), "Password Reset Request for {$mysidia->input->post("username")}", $message, $headers);
	        }
            return;
		}		  
	}
	
	public function reset(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    $passwordResets = $mysidia->db->select("passwordresets", array(), "username = '{$mysidia->input->post("username")}' and email = '{$mysidia->input->post("email")}' and code='{$mysidia->input->post("resetcode")}' ORDER BY id DESC LIMIT 1")->fetchObject();	
		    if(!is_object($passwordResets)) throw new InvalidCodeException("invalidcode");		
	        else{		
		        $newPass = $mysidia->user->reset($passwordResets->username, $passwordResets->email); 
                $this->setField("newPass", new String($newPass));				
	        }		 	    
			return;
		}
	}
}
?>