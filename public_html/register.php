<?php

use Resource\Native\Mystring;
use Resource\Collection\HashMap;

class RegisterController extends AppController{

    public function __construct(){
        parent::__construct("guest");
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    $mysidia->session->validate("register");	
            $validinput = array("username" => $mysidia->input->post("username"), "password" => $mysidia->input->post("pass1"), "email" => $mysidia->input->post("email"), "birthday" => $mysidia->input->post("birthday"), 
                                "ip" => $mysidia->input->post("ip"), "answer" => $mysidia->input->post("answer"), "tos" => $mysidia->input->post("tos"));
            $validator = new RegisterValidator($mysidia->user, $validinput);
            $validator->validate();
  
            if(!$validator->triggererror()){
	            $mysidia->user->register();	
				include("inc/config_forums.php");
	            if($mybbenabled == 1){
                    include_once("functions/functions_forums.php");   
                    mybbregister();
                    mybbrebuildstats();
                }
	            $mysidia->user->login($mysidia->input->post("username"));
            }
            else throw new RegisterException($validator->triggererror());  
			$mysidia->session->terminate("register");
			return;
		}
		$mysidia->session->assign("register", 1, TRUE);		
	}              
}
?>