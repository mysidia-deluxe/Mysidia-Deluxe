<?php

class ACPUserController extends AppController{

	const PARAM = "uid";
	
	public function __construct(){
	    parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanageusers") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage users.");
		}	
	}
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");	
		$stmt = $mysidia->db->select("users");		
        $this->setField("stmt", new DatabaseStatement($stmt));
	}
	
	public function add(){
	    throw new InvalidActionException("global_action");
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("uid")){
		    $this->index();
			return;
		}
		$user = new Member($mysidia->input->get("uid"));		
		
		if($mysidia->input->post("submit")){
		    // A form has been submitted, we will be processing the request.
			if($mysidia->input->post("pass1")){
                $newsalt = codegen(15, 0); 
			    $password = passencr($username, $pass1, $newsalt);
				$mysidia->db->update("users", array("password" => $password), "uid='{$mysidia->input->get("uid")}'");
				if($mysidia->input->post("emailpwchange") == "yes"){
					//SEND THE PASSWORD CHANGE EMAIL...	
                    $systememail = $mysidia->settings->systememail;
					$headers = "From: {$systememail}";
					$message = "Hello {$user->username};\n\nYour password at {$mysidia->settings->sitename} has been changed by the site admin. Your new account details are as follows:\n
						        Username: {$user->username}\nPassword: {$mysidia->input->post("pass1")}\n
						        You can log in to your account at: {$mysidia->path->getAbsolute()}login\n
						        Thank You. The {$mysidia->settings->sitename} team.";
					mail($mysidia->input->post("email"), "{$mysidia->settings->sitename} - Your password has been changed", $message, $headers);					
				}
			}
				
			$mysidia->db->update("users", array("email" => $mysidia->input->post("email")), "uid='{$mysidia->input->get("uid")}'");
			if(is_numeric($mysidia->input->post("level"))) $mysidia->db->update("users", array("usergroup" => $mysidia->input->post("level")), "uid='{$mysidia->input->get("uid")}'");
			
            //Carry out user banning options
			if($mysidia->input->post("canlevel") == "no") $mysidia->db->update("users_status", array("canlevel" => 'no'), "uid='{$mysidia->input->get("uid")}'");
            if($mysidia->input->post("canvm") == "no") $mysidia->db->update("users_status", array("canvm" => 'no'), "uid='{$mysidia->input->get("uid")}'");
            if($mysidia->input->post("canfriend") == "no") $mysidia->db->update("users_status", array("canfriend" => 'no'), "uid='{$mysidia->input->get("uid")}'");
            if($mysidia->input->post("cantrade") == "no") $mysidia->db->update("users_status", array("cantrade" => 'no'), "uid='{$mysidia->input->get("uid")}'");
            if($mysidia->input->post("canbreed") == "no") $mysidia->db->update("users_status", array("canbreed" => 'no'), "uid='{$mysidia->input->get("uid")}'");
            if($mysidia->input->post("canpound") == "no") $mysidia->db->update("users_status", array("canpound" => 'no'), "uid='{$mysidia->input->get("uid")}'");  
            if($mysidia->input->post("canshop") == "no") $mysidia->db->update("users_status", array("canshop" => 'no'), "uid='{$mysidia->input->get("uid")}'");
            if($mysidia->input->post("unban") == "yes") unbanuser($user->username);
		}
	}
	
	public function delete(){
	 	$mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("uid")){
		    $this->index();
			return;
		}

        $user = new Member($mysidia->input->get("uid"));
		deleteuser($user->username);
	}
	
	public function merge(){
	    throw new InvalidActionException("global_action");
	}
	
	public function search(){
	    throw new InvalidActionException("global_action");
	}
}
?>