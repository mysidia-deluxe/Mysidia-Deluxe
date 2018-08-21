<?php

use Resource\Native\Mystring;
use Resource\Collection\ArrayList;

class AccountController extends AppController{

    public function __construct(){
        parent::__construct("member");	
    }
	
	public function password(){
		$mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    $newsalt = codegen(15,0);
            $newpass1 = passencr($mysidia->user->username, $mysidia->input->post("np1"), $newsalt);
            $newpass2 = passencr($mysidia->user->username, $mysidia->input->post("np2"), $newsalt);
            $userdata = $mysidia->db->select("users", array("uid", "username", "password", "salt", "session"), "username='{$mysidia->user->username}'")->fetchObject();	
            $currentpass = passencr($userdata->username, $mysidia->input->post("cpass"), $userdata->salt);
  
            if($currentpass != $userdata->password) throw new PasswordException("password_current");
            elseif($newpass1 != $newpass2) throw new PasswordException("password_new");
            elseif(!$mysidia->input->post("np1") or !$mysidia->input->post("np2")) throw new PasswordException("password_blank");
            else{
	            $mysidia->db->update("users", array("password" => $newpass1, "salt" => $newsalt), "username='{$mysidia->user->username}' AND password='{$currentpass}'");	 
                $mysidia->cookies->deletecookies();
            }
		}
	}
	
	public function email(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    $validator = new UserValidator($mysidia->user, array("email" => $mysidia->input->post("email")));
            $validator->validate("email");
			
            if(!$validator->triggererror()) $mysidia->db->update("users", array("email" => $mysidia->input->post("email")), "username = '{$mysidia->user->username}'");
            else throw new EmailException("email_invalid");
		}
	}
	
	public function friends(){
		$mysidia = Registry::get("mysidia");
	    $this->setField("friendlist", new FriendList($mysidia->user));
	}
	
	public function profile(){
		$mysidia = Registry::get("mysidia");
		$profile = $mysidia->user->getprofile();
		
	    if($mysidia->input->post("submit")){
		    $mysidia->db->update("users_profile", array("avatar" => $mysidia->input->post("avatar"), "nickname" => $mysidia->input->post("nickname"), "gender" => $mysidia->input->post("gender"), "color" => $mysidia->input->post("color"), "bio" => $mysidia->input->post("bio"), "favpet" => $mysidia->input->post("favpet"), "about" => $mysidia->input->post("about")), "username = '{$mysidia->user->username}'");
			return;
		}
		
        if(!($profile instanceof UserProfile)) throw new ProfileException("profile_nonexist");
        elseif($mysidia->user->uid != $profile->uid) throw new ProfileException("profile_edit");
        else{   
            $stmt = $mysidia->db->select("owned_adoptables", array("name", "aid"), "owner = '{$mysidia->user->username}'");
            $map = $mysidia->db->fetchMap($stmt);
	        $this->setField("profile", $profile);
			$this->setField("petMap", $map);
        }
	}
	
	public function contacts(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    $newmsgnotify = ($mysidia->input->post("newmsgnotify") == 1)?1:0;
            $mysidia->db->update("users_options", array("newmessagenotify" => $newmsgnotify), "username='{$mysidia->user->username}'");
            $mysidia->db->update("users_contacts", array("website" => $mysidia->input->post("website"), "facebook" => $mysidia->input->post("facebook"), "twitter" => $mysidia->input->post("twitter"), "aim" => $mysidia->input->post("aim"), "yahoo" => $mysidia->input->post("yim"), "msn" => $mysidia->input->post("msn"), "skype" => $mysidia->input->post("skype")), "username = '{$mysidia->user->username}'");
		    return;
		}
        
        $contactList = new ArrayList;	
		$contactList->add(new Mystring("website"));
		$contactList->add(new Mystring("facebook"));
		$contactList->add(new Mystring("twitter"));	
		$contactList->add(new Mystring("msn"));
		$contactList->add(new Mystring("aim"));
		$contactList->add(new Mystring("yim"));
		$contactList->add(new Mystring("skype"));	
		$this->setField("contactList", $contactList);
	}
}
?>